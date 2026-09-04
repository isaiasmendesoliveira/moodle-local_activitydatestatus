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

/**
 * Persistence and defaults for per-course-module display settings.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class settings_manager {
    /** @var string Exact dates only. */
    public const MODE_DATES = 'dates';
    /** @var string Relative status only. */
    public const MODE_STATUS = 'status';
    /** @var string Exact dates plus relative status. */
    public const MODE_BOTH = 'both';

    /** @var string Bootstrap badge presentation. */
    public const STYLE_BADGE = 'badge';
    /** @var string Coloured text presentation. */
    public const STYLE_TEXT = 'text';

    /** Maximum threshold accepted in hours (one year). */
    private const MAX_HOURS = 8760;

    /**
     * Return site defaults used when an activity has no saved configuration yet.
     *
     * @return \stdClass
     */
    public static function get_defaults(): \stdClass {
        return (object) [
            'enabled' => (int) self::get_config_int('defaultenabled', 0, 0, 1),
            'displaymode' => self::normalise_display_mode(
                (string) (get_config('local_activitydatestatus', 'defaultdisplaymode') ?: self::MODE_BOTH)
            ),
            'statusstyle' => self::normalise_status_style(
                (string) (get_config('local_activitydatestatus', 'defaultstatusstyle') ?: self::STYLE_BADGE)
            ),
            'warninghours' => self::get_config_int('defaultwarninghours', 48, 0, self::MAX_HOURS),
            'criticalhours' => self::get_config_int('defaultcriticalhours', 12, 0, self::MAX_HOURS),
        ];
    }

    /**
     * Return saved settings for a course module, falling back to site defaults.
     *
     * @param int $cmid Course module id. Zero is accepted for a new activity.
     * @return \stdClass
     */
    public static function get_settings(int $cmid): \stdClass {
        global $DB;

        if ($cmid > 0) {
            $record = $DB->get_record('local_activitydatestatus', ['cmid' => $cmid]);
            if ($record) {
                return self::normalise_settings($record);
            }
        }

        return self::normalise_settings(self::get_defaults());
    }

    /**
     * Store all teacher-controlled settings for one course module.
     *
     * @param int $cmid Course module id.
     * @param bool $enabled Whether the indicator is enabled.
     * @param string $displaymode Display mode.
     * @param string $statusstyle Status presentation style.
     * @param int $warninghours Attention threshold in hours; 0 disables it.
     * @param int $criticalhours Critical threshold in hours; 0 disables it.
     * @return void
     */
    public static function set_settings(
        int $cmid,
        bool $enabled,
        string $displaymode,
        string $statusstyle,
        int $warninghours,
        int $criticalhours
    ): void {
        global $DB;

        if ($cmid <= 0) {
            return;
        }

        $warninghours = self::normalise_hours($warninghours);
        $criticalhours = self::normalise_hours($criticalhours);
        if ($warninghours === 0) {
            $criticalhours = 0;
        } elseif ($criticalhours > $warninghours) {
            $criticalhours = $warninghours;
        }

        $now = time();
        $data = (object) [
            'cmid' => $cmid,
            'enabled' => $enabled ? 1 : 0,
            'displaymode' => self::normalise_display_mode($displaymode),
            'statusstyle' => self::normalise_status_style($statusstyle),
            'warninghours' => $warninghours,
            'criticalhours' => $criticalhours,
            'timemodified' => $now,
        ];

        $existing = $DB->get_record('local_activitydatestatus', ['cmid' => $cmid], 'id,timecreated');
        if ($existing) {
            $data->id = $existing->id;
            $data->timecreated = $existing->timecreated;
            $DB->update_record('local_activitydatestatus', $data);
            return;
        }

        $data->timecreated = $now;
        $DB->insert_record('local_activitydatestatus', $data);
    }

    /**
     * Whether the indicator is enabled for a course module.
     *
     * @param int $cmid Course module id.
     * @return bool
     */
    public static function is_enabled(int $cmid): bool {
        return !empty(self::get_settings($cmid)->enabled);
    }

    /**
     * Remove stale configuration when a course module is deleted.
     *
     * @param int $cmid Course module id.
     * @return void
     */
    public static function delete_for_cmid(int $cmid): void {
        global $DB;
        $DB->delete_records('local_activitydatestatus', ['cmid' => $cmid]);
    }

    /**
     * Normalise a settings record.
     *
     * @param object $settings Raw settings.
     * @return \stdClass
     */
    private static function normalise_settings(object $settings): \stdClass {
        $warninghours = self::normalise_hours((int) ($settings->warninghours ?? 48));
        $criticalhours = self::normalise_hours((int) ($settings->criticalhours ?? 12));
        if ($warninghours === 0) {
            $criticalhours = 0;
        } elseif ($criticalhours > $warninghours) {
            $criticalhours = $warninghours;
        }

        return (object) [
            'enabled' => !empty($settings->enabled) ? 1 : 0,
            'displaymode' => self::normalise_display_mode((string) ($settings->displaymode ?? self::MODE_BOTH)),
            'statusstyle' => self::normalise_status_style((string) ($settings->statusstyle ?? self::STYLE_BADGE)),
            'warninghours' => $warninghours,
            'criticalhours' => $criticalhours,
        ];
    }

    /**
     * Validate one display mode.
     *
     * Legacy automatic values are migrated conservatively to Dates + status.
     *
     * @param string $mode Requested mode.
     * @return string
     */
    public static function normalise_display_mode(string $mode): string {
        $allowed = [self::MODE_DATES, self::MODE_STATUS, self::MODE_BOTH];
        return in_array($mode, $allowed, true) ? $mode : self::MODE_BOTH;
    }

    /**
     * Validate the status presentation style.
     *
     * @param string $style Requested style.
     * @return string
     */
    public static function normalise_status_style(string $style): string {
        $allowed = [self::STYLE_BADGE, self::STYLE_TEXT];
        return in_array($style, $allowed, true) ? $style : self::STYLE_BADGE;
    }

    /**
     * Clamp hours to a safe range.
     *
     * @param int $hours Hours.
     * @return int
     */
    private static function normalise_hours(int $hours): int {
        return max(0, min(self::MAX_HOURS, $hours));
    }

    /**
     * Read and clamp one integer site setting.
     *
     * @param string $name Setting name.
     * @param int $default Default value.
     * @param int $minimum Minimum value.
     * @param int $maximum Maximum value.
     * @return int
     */
    private static function get_config_int(string $name, int $default, int $minimum, int $maximum): int {
        $value = get_config('local_activitydatestatus', $name);
        if ($value === false || !is_numeric($value)) {
            return $default;
        }
        return max($minimum, min($maximum, (int) $value));
    }
}
