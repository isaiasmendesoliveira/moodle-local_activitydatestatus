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
 * Backup support for Activity Date Status course-module settings.
 *
 * @package    local_activitydatestatus
 * @category   backup
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/moodle2/backup_local_plugin.class.php');

/**
 * Adds Activity Date Status settings to each course-module backup.
 *
 * @package    local_activitydatestatus
 * @category   backup
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_local_activitydatestatus_plugin extends backup_local_plugin {
    /**
     * Define the plugin structure attached to a course module.
     *
     * @return backup_plugin_element Plugin element containing the settings structure.
     */
    protected function define_module_plugin_structure() {
        $plugin = $this->get_plugin_element();
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());
        $settings = new backup_nested_element(
            'settings',
            null,
            [
                'enabled',
                'displaymode',
                'statusstyle',
                'warninghours',
                'criticalhours',
            ]
        );

        $plugin->add_child($pluginwrapper);
        $pluginwrapper->add_child($settings);

        $settings->set_source_table(
            'local_activitydatestatus',
            ['cmid' => backup::VAR_MODID]
        );

        return $plugin;
    }
}
