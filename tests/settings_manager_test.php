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

namespace local_activitydatestatus;

use local_activitydatestatus\local\settings_manager;

/**
 * Tests for public settings normalization helpers.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class settings_manager_test extends \advanced_testcase {
    /**
     * Test display-mode normalization.
     *
     * @return void
     */
    public function test_normalise_display_mode(): void {
        $this->assertSame(settings_manager::MODE_DATES, settings_manager::normalise_display_mode('dates'));
        $this->assertSame(settings_manager::MODE_STATUS, settings_manager::normalise_display_mode('status'));
        $this->assertSame(settings_manager::MODE_BOTH, settings_manager::normalise_display_mode('both'));
        $this->assertSame(settings_manager::MODE_BOTH, settings_manager::normalise_display_mode('invalid'));
    }

    /**
     * Test status-style normalization.
     *
     * @return void
     */
    public function test_normalise_status_style(): void {
        $this->assertSame(settings_manager::STYLE_BADGE, settings_manager::normalise_status_style('badge'));
        $this->assertSame(settings_manager::STYLE_TEXT, settings_manager::normalise_status_style('text'));
        $this->assertSame(settings_manager::STYLE_BADGE, settings_manager::normalise_status_style('invalid'));
    }
}
