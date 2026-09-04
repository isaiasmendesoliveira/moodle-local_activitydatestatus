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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <https://www.gnu.org/licenses/>.

/**
 * Site defaults for Activity Date Status.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_activitydatestatus',
        get_string('pluginname', 'local_activitydatestatus')
    );
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_heading(
        'local_activitydatestatus/defaultsheading',
        get_string('defaultsheading', 'local_activitydatestatus'),
        get_string('defaultsheading_desc', 'local_activitydatestatus')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_activitydatestatus/defaultenabled',
        get_string('defaultenabled', 'local_activitydatestatus'),
        get_string('defaultenabled_desc', 'local_activitydatestatus'),
        0
    ));

    $settings->add(new admin_setting_configselect(
        'local_activitydatestatus/defaultdisplaymode',
        get_string('defaultdisplaymode', 'local_activitydatestatus'),
        get_string('defaultdisplaymode_desc', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::MODE_BOTH,
        [
            \local_activitydatestatus\local\settings_manager::MODE_DATES => get_string('displaymode_dates', 'local_activitydatestatus'),
            \local_activitydatestatus\local\settings_manager::MODE_STATUS => get_string('displaymode_status', 'local_activitydatestatus'),
            \local_activitydatestatus\local\settings_manager::MODE_BOTH => get_string('displaymode_both', 'local_activitydatestatus'),
        ]
    ));

    $settings->add(new admin_setting_configselect(
        'local_activitydatestatus/defaultstatusstyle',
        get_string('defaultstatusstyle', 'local_activitydatestatus'),
        get_string('defaultstatusstyle_desc', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::STYLE_BADGE,
        [
            \local_activitydatestatus\local\settings_manager::STYLE_BADGE => get_string('statusstyle_badge', 'local_activitydatestatus'),
            \local_activitydatestatus\local\settings_manager::STYLE_TEXT => get_string('statusstyle_text', 'local_activitydatestatus'),
        ]
    ));

    $settings->add(new admin_setting_configtext(
        'local_activitydatestatus/defaultwarninghours',
        get_string('defaultwarninghours', 'local_activitydatestatus'),
        get_string('defaultwarninghours_desc', 'local_activitydatestatus'),
        48,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'local_activitydatestatus/defaultcriticalhours',
        get_string('defaultcriticalhours', 'local_activitydatestatus'),
        get_string('defaultcriticalhours_desc', 'local_activitydatestatus'),
        12,
        PARAM_INT
    ));
}
