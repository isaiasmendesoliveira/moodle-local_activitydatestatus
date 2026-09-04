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
 * Course-module form callbacks for Activity Date Status.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Add teacher-controlled Activity Date Status options to every activity/resource form.
 *
 * @param moodleform_mod $formwrapper Course module form wrapper.
 * @param MoodleQuickForm $mform MoodleQuickForm instance.
 * @return void
 */
function local_activitydatestatus_coursemodule_standard_elements(
    moodleform_mod $formwrapper,
    MoodleQuickForm $mform
): void {
    $cm = $formwrapper->get_coursemodule();
    $settings = \local_activitydatestatus\local\settings_manager::get_settings($cm ? (int) $cm->id : 0);

    $mform->addElement(
        'header',
        'local_activitydatestatus_header',
        get_string('formsection', 'local_activitydatestatus')
    );

    $mform->addElement(
        'advcheckbox',
        'local_activitydatestatus_enabled',
        get_string('enabledlabel', 'local_activitydatestatus'),
        get_string('enableddescription', 'local_activitydatestatus')
    );
    $mform->addHelpButton(
        'local_activitydatestatus_enabled',
        'enabledlabel',
        'local_activitydatestatus'
    );
    $mform->setDefault('local_activitydatestatus_enabled', (int) $settings->enabled);
    $mform->setType('local_activitydatestatus_enabled', PARAM_BOOL);

    $moderadios = [];
    $moderadios[] = $mform->createElement(
        'radio',
        'local_activitydatestatus_displaymode',
        '',
        get_string('displaymode_dates', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::MODE_DATES
    );
    $moderadios[] = $mform->createElement(
        'radio',
        'local_activitydatestatus_displaymode',
        '',
        get_string('displaymode_status', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::MODE_STATUS
    );
    $moderadios[] = $mform->createElement(
        'radio',
        'local_activitydatestatus_displaymode',
        '',
        get_string('displaymode_both', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::MODE_BOTH
    );
    $mform->addGroup(
        $moderadios,
        'local_activitydatestatus_displaymode_group',
        get_string('displaymode', 'local_activitydatestatus'),
        ['<br>'],
        false
    );
    $mform->addHelpButton(
        'local_activitydatestatus_displaymode_group',
        'displaymode',
        'local_activitydatestatus'
    );
    $mform->setDefault('local_activitydatestatus_displaymode', $settings->displaymode);
    $mform->setType('local_activitydatestatus_displaymode', PARAM_ALPHA);
    $mform->disabledIf('local_activitydatestatus_displaymode_group', 'local_activitydatestatus_enabled', 'notchecked');

    $styleradios = [];
    $styleradios[] = $mform->createElement(
        'radio',
        'local_activitydatestatus_statusstyle',
        '',
        get_string('statusstyle_badge', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::STYLE_BADGE
    );
    $styleradios[] = $mform->createElement(
        'radio',
        'local_activitydatestatus_statusstyle',
        '',
        get_string('statusstyle_text', 'local_activitydatestatus'),
        \local_activitydatestatus\local\settings_manager::STYLE_TEXT
    );
    $mform->addGroup(
        $styleradios,
        'local_activitydatestatus_statusstyle_group',
        get_string('statusstyle', 'local_activitydatestatus'),
        ['<br>'],
        false
    );
    $mform->addHelpButton(
        'local_activitydatestatus_statusstyle_group',
        'statusstyle',
        'local_activitydatestatus'
    );
    $mform->setDefault('local_activitydatestatus_statusstyle', $settings->statusstyle);
    $mform->setType('local_activitydatestatus_statusstyle', PARAM_ALPHA);
    $mform->disabledIf('local_activitydatestatus_statusstyle_group', 'local_activitydatestatus_enabled', 'notchecked');
    $mform->disabledIf(
        'local_activitydatestatus_statusstyle_group',
        'local_activitydatestatus_displaymode',
        'eq',
        \local_activitydatestatus\local\settings_manager::MODE_DATES
    );

    $warningelements = [];
    $warningelements[] = $mform->createElement(
        'text',
        'local_activitydatestatus_warninghours',
        '',
        ['size' => 5]
    );
    $warningelements[] = $mform->createElement(
        'static',
        'local_activitydatestatus_warninghours_suffix',
        '',
        get_string('hoursbefore', 'local_activitydatestatus')
    );
    $mform->addGroup(
        $warningelements,
        'local_activitydatestatus_warninghours_group',
        get_string('warninghoursactivity', 'local_activitydatestatus'),
        [' '],
        false
    );
    $mform->addHelpButton(
        'local_activitydatestatus_warninghours_group',
        'warninghoursactivity',
        'local_activitydatestatus'
    );
    $mform->setDefault('local_activitydatestatus_warninghours', (int) $settings->warninghours);
    $mform->setType('local_activitydatestatus_warninghours', PARAM_INT);
    $mform->disabledIf('local_activitydatestatus_warninghours', 'local_activitydatestatus_enabled', 'notchecked');
    $mform->disabledIf(
        'local_activitydatestatus_warninghours',
        'local_activitydatestatus_displaymode',
        'eq',
        \local_activitydatestatus\local\settings_manager::MODE_DATES
    );

    $criticalelements = [];
    $criticalelements[] = $mform->createElement(
        'text',
        'local_activitydatestatus_criticalhours',
        '',
        ['size' => 5]
    );
    $criticalelements[] = $mform->createElement(
        'static',
        'local_activitydatestatus_criticalhours_suffix',
        '',
        get_string('hoursbefore', 'local_activitydatestatus')
    );
    $mform->addGroup(
        $criticalelements,
        'local_activitydatestatus_criticalhours_group',
        get_string('criticalhoursactivity', 'local_activitydatestatus'),
        [' '],
        false
    );
    $mform->addHelpButton(
        'local_activitydatestatus_criticalhours_group',
        'criticalhoursactivity',
        'local_activitydatestatus'
    );
    $mform->setDefault('local_activitydatestatus_criticalhours', (int) $settings->criticalhours);
    $mform->setType('local_activitydatestatus_criticalhours', PARAM_INT);
    $mform->disabledIf('local_activitydatestatus_criticalhours', 'local_activitydatestatus_enabled', 'notchecked');
    $mform->disabledIf(
        'local_activitydatestatus_criticalhours',
        'local_activitydatestatus_displaymode',
        'eq',
        \local_activitydatestatus\local\settings_manager::MODE_DATES
    );
    $mform->setAdvanced('local_activitydatestatus_criticalhours_group');

    $mform->addElement(
        'static',
        'local_activitydatestatus_source_note',
        '',
        get_string('sourcenote', 'local_activitydatestatus')
    );
}

/**
 * Save teacher-controlled settings after an activity/resource is saved.
 *
 * @param stdClass $moduleinfo Saved module information.
 * @param stdClass $course Course record.
 * @return stdClass
 */
function local_activitydatestatus_coursemodule_edit_post_actions(
    stdClass $moduleinfo,
    stdClass $course
): stdClass {
    if (empty($moduleinfo->coursemodule)) {
        return $moduleinfo;
    }

    $defaults = \local_activitydatestatus\local\settings_manager::get_defaults();
    $displaymode = isset($moduleinfo->local_activitydatestatus_displaymode)
        ? (string) $moduleinfo->local_activitydatestatus_displaymode
        : (string) $defaults->displaymode;
    $statusstyle = isset($moduleinfo->local_activitydatestatus_statusstyle)
        ? (string) $moduleinfo->local_activitydatestatus_statusstyle
        : (string) $defaults->statusstyle;
    $warninghours = isset($moduleinfo->local_activitydatestatus_warninghours)
        ? (int) $moduleinfo->local_activitydatestatus_warninghours
        : (int) $defaults->warninghours;
    $criticalhours = isset($moduleinfo->local_activitydatestatus_criticalhours)
        ? (int) $moduleinfo->local_activitydatestatus_criticalhours
        : (int) $defaults->criticalhours;

    \local_activitydatestatus\local\settings_manager::set_settings(
        (int) $moduleinfo->coursemodule,
        !empty($moduleinfo->local_activitydatestatus_enabled),
        $displaymode,
        $statusstyle,
        $warninghours,
        $criticalhours
    );

    return $moduleinfo;
}
