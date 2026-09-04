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

use core\hook\output\before_footer_html_generation;

/**
 * Output hooks for Activity Date Status.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class hook_callbacks {
    /**
     * Load the course-page enhancer only on real course pages with configured items.
     *
     * @param before_footer_html_generation $hook Hook instance.
     * @return void
     */
    public static function before_footer_html_generation(before_footer_html_generation $hook): void {
        global $CFG, $COURSE, $PAGE;

        if (during_initial_install() || isset($CFG->upgraderunning)) {
            return;
        }
        if (!get_config('local_activitydatestatus', 'version')) {
            return;
        }
        if (empty($COURSE->id) || $COURSE->id <= SITEID) {
            return;
        }
        if (strpos((string) $PAGE->pagetype, 'course-view-') !== 0) {
            return;
        }

        $items = course_data::get_for_course((int) $COURSE->id);
        if (!$items) {
            return;
        }

        $locale = str_replace('_', '-', current_language());
        $PAGE->requires->js_call_amd(
            'local_activitydatestatus/course',
            'init',
            [$items, time(), $locale]
        );
    }
}
