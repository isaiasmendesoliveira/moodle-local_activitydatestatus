# Release notes — Activity Date Status 1.0.0

Activity Date Status 1.0.0 is the first public release.

## Highlights

- Per-activity teacher control over date/status presentation.
- Dates only, Status only, and Dates + status modes.
- Bootstrap 5 badges or coloured text with SVG icons.
- Configurable warning and critical deadline thresholds.
- Moodle core `activity_dates` API remains the single date source.
- User-specific dates and supported overrides are respected by relying on Moodle core.
- Fail-safe replacement of Moodle's native date block.
- Site defaults with per-activity teacher overrides.
- No personal-data storage and no external service dependencies.

## Compatibility

- Moodle 4.5–5.2.
- PHP compatibility follows the supported Moodle branch.

## Upgrade note for development builds

The public release number is reset to **1.0.0**. The internal Moodle build number is `2026090409`, which is higher than the final development build (`2026090403`), so a development installation can be upgraded directly without a database downgrade.
