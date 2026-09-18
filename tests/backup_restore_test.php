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

namespace local_activitydatestatus;

use local_activitydatestatus\local\settings_manager;

global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

/**
 * Tests backup and restore of course-module presentation settings.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversNothing
 */
final class backup_restore_test extends \advanced_testcase {
    /**
     * Test that all teacher-controlled settings survive activity backup and restore.
     *
     * @return void
     */
    public function test_activity_settings_are_restored_to_new_cmid(): void {
        global $DB, $USER;

        $this->resetAfterTest();
        $this->setAdminUser();

        $generator = $this->getDataGenerator();
        $sourcecourse = $generator->create_course();
        $targetcourse = $generator->create_course();
        $page = $generator->create_module('page', [
            'course' => $sourcecourse->id,
            'name' => 'Activity Date Status backup test',
        ]);

        settings_manager::set_settings(
            $page->cmid,
            true,
            settings_manager::MODE_STATUS,
            settings_manager::STYLE_TEXT,
            72,
            6
        );

        $backup = new \backup_controller(
            \backup::TYPE_1ACTIVITY,
            $page->cmid,
            \backup::FORMAT_MOODLE,
            \backup::INTERACTIVE_NO,
            \backup::MODE_IMPORT,
            $USER->id
        );
        $backupid = $backup->get_backupid();
        $backup->execute_plan();
        $backup->destroy();

        $restore = new \restore_controller(
            $backupid,
            $targetcourse->id,
            \backup::INTERACTIVE_NO,
            \backup::MODE_IMPORT,
            $USER->id,
            \backup::TARGET_CURRENT_ADDING
        );
        $this->assertTrue($restore->execute_precheck());
        $restore->execute_plan();
        $restore->destroy();

        $restoredpage = $DB->get_record(
            'page',
            [
                'course' => $targetcourse->id,
                'name' => 'Activity Date Status backup test',
            ],
            '*',
            MUST_EXIST
        );
        $restoredcm = get_coursemodule_from_instance(
            'page',
            $restoredpage->id,
            $targetcourse->id,
            false,
            MUST_EXIST
        );
        $settings = settings_manager::get_settings($restoredcm->id);

        $this->assertSame(1, $settings->enabled);
        $this->assertSame(settings_manager::MODE_STATUS, $settings->displaymode);
        $this->assertSame(settings_manager::STYLE_TEXT, $settings->statusstyle);
        $this->assertSame(72, $settings->warninghours);
        $this->assertSame(6, $settings->criticalhours);
    }
}
