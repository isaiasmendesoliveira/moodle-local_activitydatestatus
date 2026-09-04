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
 * Upgrade steps for Activity Date Status.
 *
 * @package    local_activitydatestatus
 * @copyright  2026 Isaias Mendes de Oliveira
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade Activity Date Status.
 *
 * @param int $oldversion Installed version.
 * @return bool
 */
function xmldb_local_activitydatestatus_upgrade(int $oldversion): bool {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2026090301) {
        $table = new xmldb_table('local_activitydatestatus');

        $enabled = new xmldb_field('enabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1', 'cmid');
        if (!$dbman->field_exists($table, $enabled)) {
            // Existing rows in 1.0.0 represented enabled activities, so preserve them as enabled.
            $dbman->add_field($table, $enabled);
        }

        $displaymode = new xmldb_field(
            'displaymode', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'auto', 'enabled'
        );
        if (!$dbman->field_exists($table, $displaymode)) {
            $dbman->add_field($table, $displaymode);
        }

        $warninghours = new xmldb_field(
            'warninghours', XMLDB_TYPE_INTEGER, '6', null, XMLDB_NOTNULL, null, '48', 'displaymode'
        );
        if (!$dbman->field_exists($table, $warninghours)) {
            $dbman->add_field($table, $warninghours);
        }

        $criticalhours = new xmldb_field(
            'criticalhours', XMLDB_TYPE_INTEGER, '6', null, XMLDB_NOTNULL, null, '12', 'warninghours'
        );
        if (!$dbman->field_exists($table, $criticalhours)) {
            $dbman->add_field($table, $criticalhours);
        }

        // Migrate previous site-wide presentation values to the new default settings.
        $oldwarning = get_config('local_activitydatestatus', 'warninghours');
        $oldcritical = get_config('local_activitydatestatus', 'criticalhours');
        if (get_config('local_activitydatestatus', 'defaultwarninghours') === false) {
            set_config('defaultwarninghours', is_numeric($oldwarning) ? (int) $oldwarning : 48, 'local_activitydatestatus');
        }
        if (get_config('local_activitydatestatus', 'defaultcriticalhours') === false) {
            set_config('defaultcriticalhours', is_numeric($oldcritical) ? (int) $oldcritical : 12, 'local_activitydatestatus');
        }
        if (get_config('local_activitydatestatus', 'defaultdisplaymode') === false) {
            set_config('defaultdisplaymode', 'auto', 'local_activitydatestatus');
        }
        if (get_config('local_activitydatestatus', 'defaultenabled') === false) {
            set_config('defaultenabled', 0, 'local_activitydatestatus');
        }

        unset_config('warninghours', 'local_activitydatestatus');
        unset_config('criticalhours', 'local_activitydatestatus');
        unset_config('exactdatemode', 'local_activitydatestatus');

        // New records should default to disabled; existing rows remain enabled.
        $enableddefault = new xmldb_field(
            'enabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'cmid'
        );
        $dbman->change_field_default($table, $enableddefault);

        upgrade_plugin_savepoint(true, 2026090301, 'local', 'activitydatestatus');
    }


    if ($oldversion < 2026090302) {
        // Presentation-only upgrade: explicit modes now replace Moodle's native
        // activity-date block for the configured activity. No schema change.
        upgrade_plugin_savepoint(true, 2026090302, 'local', 'activitydatestatus');
    }

    if ($oldversion < 2026090400) {
        $table = new xmldb_table('local_activitydatestatus');

        $statusstyle = new xmldb_field(
            'statusstyle', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'badge', 'criticalhours'
        );
        if (!$dbman->field_exists($table, $statusstyle)) {
            $dbman->add_field($table, $statusstyle);
        }

        // Automatic mode was removed. Dates + status is the safest migration
        // because it preserves both exact dates and the relative indicator while
        // the plugin takes ownership of the activity's date presentation.
        $DB->set_field('local_activitydatestatus', 'displaymode', 'both', ['displaymode' => 'auto']);
        if (get_config('local_activitydatestatus', 'defaultdisplaymode') === 'auto') {
            set_config('defaultdisplaymode', 'both', 'local_activitydatestatus');
        }
        if (get_config('local_activitydatestatus', 'defaultstatusstyle') === false) {
            set_config('defaultstatusstyle', 'badge', 'local_activitydatestatus');
        }

        $displaymode = new xmldb_field(
            'displaymode', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'both', 'enabled'
        );
        $dbman->change_field_default($table, $displaymode);

        upgrade_plugin_savepoint(true, 2026090400, 'local', 'activitydatestatus');
    }

    if ($oldversion < 2026090404) {
        // First public release. No schema change from the final development build.
        upgrade_plugin_savepoint(true, 2026090404, 'local', 'activitydatestatus');
    }

    return true;
}
