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
- Moodle backup and restore preserve enabled state, display mode, status style, and warning/critical thresholds for each restored course module.
- No personal-data storage and no external service dependencies.

## Compatibility

- Moodle 4.5–5.2.
- PHP compatibility follows the supported Moodle branch.

## Upgrade note for development builds

The public release number remains **1.0.0**. The internal Moodle build number is `2026091700`, which includes the Marketplace review fixes while preserving a clean first public release number.
