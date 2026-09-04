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
 * Lightweight semantic classifier for data IDs supplied by core activity_dates.
 *
 * The timestamp and label always come from Moodle core. Classification is used
 * only to select a restrained icon/colour; it never changes access rules or dates.
 * Unknown third-party IDs remain neutral.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class date_classifier {
    /** Activity opening date. */
    public const OPENING = 'opening';

    /** Soft due date. */
    public const DUE = 'due';

    /** Activity closing or hard deadline date. */
    public const CLOSING = 'closing';

    /** Date with no known semantic classification. */
    public const NEUTRAL = 'neutral';

    /**
     * Classify a Moodle activity-date dataid conservatively.
     *
     * @param string $dataid Activity date identifier.
     * @return string One of the class constants.
     */
    public static function classify(string $dataid): string {
        $id = strtolower(trim($dataid));
        if ($id === '') {
            return self::NEUTRAL;
        }

        // Soft deadlines must be checked before generic end/close patterns.
        if (in_array($id, ['duedate', 'due'], true) || preg_match('/(^|_)due(date)?($|_)/', $id)) {
            return self::DUE;
        }

        $closingids = [
            'timeclose', 'deadline', 'cutoffdate', 'submissionend', 'assessmentend',
            'timeend', 'enddate', 'close', 'closingtime', 'availableto', 'timeavailableto',
            'timeviewto',
        ];
        if (
            in_array($id, $closingids, true)
            || preg_match('/(close|closing|cutoff|deadline|end$|enddate|until|availableto|viewto)/', $id)
        ) {
            return self::CLOSING;
        }

        $openingids = [
            'timeopen', 'available', 'allowsubmissionsfromdate', 'submissionstart', 'assessmentstart',
            'timestart', 'startdate', 'open', 'openingtime', 'availablefrom', 'timeavailablefrom',
            'timeviewfrom',
        ];
        if (
            in_array($id, $openingids, true)
            || preg_match('/(open|opening|start|from$|fromdate|availablefrom|viewfrom)/', $id)
        ) {
            return self::OPENING;
        }

        return self::NEUTRAL;
    }
}
