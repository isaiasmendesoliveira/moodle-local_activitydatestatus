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

/**
 * Restore support for Activity Date Status course-module settings.
 *
 * @package    local_activitydatestatus
 * @category   backup
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/moodle2/restore_local_plugin.class.php');

/**
 * Restores Activity Date Status settings against the new course-module id.
 *
 * @package    local_activitydatestatus
 * @category   backup
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_local_activitydatestatus_plugin extends restore_local_plugin {
    /**
     * Define the plugin paths attached to a restored course module.
     *
     * @return restore_path_element[] Restore paths handled by this plugin.
     */
    protected function define_module_plugin_structure() {
        return [
            new restore_path_element(
                'activitydatestatus_settings',
                $this->get_pathfor('/settings')
            ),
        ];
    }

    /**
     * Restore the settings row for the newly created course module.
     *
     * @param array $data Settings data from the backup file.
     * @return void
     */
    public function process_activitydatestatus_settings($data): void {
        $data = (object) $data;
        $cmid = (int) $this->get_task()->get_moduleid();

        if ($cmid <= 0) {
            return;
        }

        \local_activitydatestatus\local\settings_manager::set_settings(
            $cmid,
            !empty($data->enabled),
            (string) ($data->displaymode ?? \local_activitydatestatus\local\settings_manager::MODE_BOTH),
            (string) ($data->statusstyle ?? \local_activitydatestatus\local\settings_manager::STYLE_BADGE),
            (int) ($data->warninghours ?? 48),
            (int) ($data->criticalhours ?? 12)
        );
    }
}
