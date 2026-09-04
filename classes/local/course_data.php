<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_activitydatestatus\local;

use core\activity_dates;

/**
 * Build user-specific Activity Date Status payloads for a course page.
 *
 * Dates are obtained exclusively from Moodle's core activity_dates API.
 * Presentation settings come from the teacher's per-activity configuration.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class course_data {
    /**
     * Return configured, visible activities which expose core activity dates.
     *
     * @param int $courseid Course id.
     * @return array<int, array<string, mixed>>
     */
    public static function get_for_course(int $courseid): array {
        global $DB, $USER;

        if ($courseid <= SITEID) {
            return [];
        }

        $records = $DB->get_records_sql(
            "SELECT s.*
               FROM {local_activitydatestatus} s
               JOIN {course_modules} cm ON cm.id = s.cmid
              WHERE cm.course = :courseid
                AND s.enabled = 1",
            ['courseid' => $courseid]
        );
        if (!$records) {
            return [];
        }

        $course = get_course($courseid);
        $modinfo = get_fast_modinfo($course);
        $dateformat = get_string('strftimedatetime', 'langconfig');
        $items = [];

        foreach ($records as $record) {
            $cmid = (int) $record->cmid;
            if (!isset($modinfo->cms[$cmid])) {
                continue;
            }

            $cm = $modinfo->cms[$cmid];
            if (!$cm->is_visible_on_course_page()) {
                continue;
            }

            try {
                $dates = activity_dates::get_dates_for_module($cm, (int) $USER->id);
            } catch (\Throwable $exception) {
                debugging(
                    'Activity Date Status could not read dates for course module ' . $cmid . ': ' . $exception->getMessage(),
                    DEBUG_DEVELOPER
                );
                continue;
            }

            $normalised = [];
            $position = 0;
            foreach ($dates as $date) {
                $timestamp = (int) ($date['timestamp'] ?? 0);
                $label = trim(strip_tags((string) ($date['label'] ?? '')));
                if ($timestamp <= 0 || $label === '') {
                    continue;
                }

                $dataid = clean_param((string) ($date['dataid'] ?? ''), PARAM_ALPHANUMEXT);
                $normalised[] = [
                    'timestamp' => $timestamp,
                    'label' => $label,
                    'dataid' => $dataid,
                    'kind' => date_classifier::classify($dataid),
                    'exact' => userdate($timestamp, $dateformat),
                    '_position' => $position++,
                ];
            }

            if (!$normalised) {
                continue;
            }

            usort($normalised, static function (array $a, array $b): int {
                $comparison = $a['timestamp'] <=> $b['timestamp'];
                return $comparison !== 0 ? $comparison : ($a['_position'] <=> $b['_position']);
            });
            foreach ($normalised as &$date) {
                unset($date['_position']);
            }
            unset($date);

            $settings = self::normalise_record_settings($record);
            $items[] = [
                'cmid' => $cmid,
                'dates' => array_values($normalised),
                'displaymode' => $settings->displaymode,
                'statusstyle' => $settings->statusstyle,
                'warningseconds' => (int) $settings->warninghours * HOURSECS,
                'criticalseconds' => (int) $settings->criticalhours * HOURSECS,
            ];
        }

        return $items;
    }

    /**
     * Normalise persisted settings without extra DB access.
     *
     * @param \stdClass $record Database record.
     * @return \stdClass
     */
    private static function normalise_record_settings(\stdClass $record): \stdClass {
        $warninghours = max(0, min(8760, (int) ($record->warninghours ?? 48)));
        $criticalhours = max(0, min(8760, (int) ($record->criticalhours ?? 12)));
        if ($warninghours === 0) {
            $criticalhours = 0;
        } elseif ($criticalhours > $warninghours) {
            $criticalhours = $warninghours;
        }

        return (object) [
            'displaymode' => settings_manager::normalise_display_mode((string) ($record->displaymode ?? 'both')),
            'statusstyle' => settings_manager::normalise_status_style((string) ($record->statusstyle ?? 'badge')),
            'warninghours' => $warninghours,
            'criticalhours' => $criticalhours,
        ];
    }
}
