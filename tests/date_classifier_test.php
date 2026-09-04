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

use local_activitydatestatus\local\date_classifier;

/**
 * Tests for activity-date semantic classification.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_activitydatestatus\local\date_classifier
 */
final class date_classifier_test extends \advanced_testcase {
    /**
     * Test semantic classification of activity date identifiers.
     *
     * @dataProvider classification_provider
     */
    public function test_classify(string $dataid, string $expected): void {
        $this->assertSame($expected, date_classifier::classify($dataid));
    }

    /**
     * Classification scenarios based on common Moodle core data IDs.
     *
     * @return array
     */
    public static function classification_provider(): array {
        return [
            'quiz open' => ['timeopen', date_classifier::OPENING],
            'assignment submissions from' => ['allowsubmissionsfromdate', date_classifier::OPENING],
            'generic start' => ['submissionstart', date_classifier::OPENING],
            'quiz close' => ['timeclose', date_classifier::CLOSING],
            'lesson deadline' => ['deadline', date_classifier::CLOSING],
            'final cutoff' => ['cutoffdate', date_classifier::CLOSING],
            'assignment due' => ['duedate', date_classifier::DUE],
            'forum due' => ['due', date_classifier::DUE],
            'unknown third party' => ['reviewwindow', date_classifier::NEUTRAL],
            'missing dataid' => ['', date_classifier::NEUTRAL],
        ];
    }
}
