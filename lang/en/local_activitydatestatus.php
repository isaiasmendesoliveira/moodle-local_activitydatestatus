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
 * Language strings for Activity Date Status.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['criticalhoursactivity'] = 'Highlight critical urgency';
$string['criticalhoursactivity_help'] = 'Optional. When a due or closing date falls within this interval, the status changes to the critical state (Bootstrap danger). Enter 0 to disable it. The effective value is never greater than the deadline-proximity interval.';
$string['defaultcriticalhours'] = 'Default critical urgency (hours)';
$string['defaultcriticalhours_desc'] = 'Initial critical-highlight threshold. Default: 12 hours. Use 0 to disable.';
$string['defaultdisplaymode'] = 'Default display mode';
$string['defaultdisplaymode_desc'] = 'The initially selected mode in each activity configuration. Teachers can override it individually.';
$string['defaultenabled'] = 'Enable by default';
$string['defaultenabled_desc'] = 'Sets the initial state of “Display date and deadline indicator”. It does not retroactively change already configured activities.';
$string['defaultsheading'] = 'Defaults for new activities';
$string['defaultsheading_desc'] = 'These values are only starting points when an activity is created or configured for the first time. Teachers can change every option individually in each activity.';
$string['defaultstatusstyle'] = 'Default status appearance';
$string['defaultstatusstyle_desc'] = 'Sets the initial status presentation. Bootstrap 5 badge is recommended and can be changed by the teacher in each activity.';
$string['defaultwarninghours'] = 'Default deadline proximity (hours)';
$string['defaultwarninghours_desc'] = 'Initial attention-highlight threshold. Default: 48 hours. Use 0 to disable.';
$string['displaymode'] = 'Display mode';
$string['displaymode_both'] = 'Dates + status (recommended)';
$string['displaymode_dates'] = 'Dates only';
$string['displaymode_help'] = 'Choose exactly what this activity should display. In all modes, the plugin replaces only this activity\'s native date block after it has successfully rendered its own content, preventing duplication. If the plugin cannot build its output, Moodle\'s native dates remain visible.';
$string['displaymode_status'] = 'Status only';
$string['enableddescription'] = 'Displays exact dates, relative status, or both on the course page according to the settings below.';
$string['enabledlabel'] = 'Display date and deadline indicator';
$string['enabledlabel_help'] = 'When enabled, the plugin uses only dates supplied by Moodle\'s native activity-dates API. Dates and access rules remain controlled by the activity itself and may vary by user, including module-supported overrides.';
$string['formsection'] = 'Date and deadline indicator';
$string['hoursbefore'] = 'hours before';
$string['pluginname'] = 'Activity Date Status';
$string['privacy:metadata'] = 'The Activity Date Status plugin does not store personal data.';
$string['sourcenote'] = '<small class="text-muted">Dates come from Moodle\'s native API. The plugin replaces only the presentation of dates for this activity; opening, closing, due dates, overrides, and access rules are not changed.</small>';
$string['statusstyle'] = 'Status appearance';
$string['statusstyle_badge'] = 'Bootstrap 5 badge (recommended)';
$string['statusstyle_help'] = 'Choose how the relative status is presented. Bootstrap 5 badge uses Moodle/theme Bootstrap utility classes such as badge, bg-success, bg-warning and bg-danger. Coloured text uses the corresponding text-* utilities. Icons inherit the same colour.';
$string['statusstyle_text'] = 'Coloured text with icon';
$string['warninghoursactivity'] = 'Highlight deadline proximity';
$string['warninghoursactivity_help'] = 'When a due or closing date falls within this interval, the status changes to the attention state (Bootstrap warning). Enter 0 to disable this highlight. Example: 48 hours.';
