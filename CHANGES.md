# Changelog

## 1.0.0 - 2026-09-17
- Adds Moodle backup and restore integration for all five per-activity presentation settings, remapping them to the restored course-module ID.
- Adds Moodle-standard JavaScript module metadata to `amd/src/course.js` (`@module`, `@package`, copyright, and GPL licence).
- Requires the production AMD build and source map to be regenerated with Moodle Grunt after source changes.
- Keeps the public release at 1.0.0 while advancing the internal build number for Marketplace review fixes.

### Earlier 1.0.0 release-candidate refinements

- Adds a canonical Moodle Grunt AMD build workflow and release-time AMD rebuild to keep `course.min.js` and its source map synchronized.

Initial public release of **Activity Date Status**.

CI packaging refinements for the 1.0.0 release candidate:

- Fixes Moodle Grunt linting for JavaScript line length and CSS `!important` usage.
- Relies on Bootstrap 5 flex and semantic colour utilities for status layout and colours.
- Aligns conditional syntax with Moodle CodeSniffer (`else if`).
- Removes an unnecessary `MOODLE_INTERNAL` guard from `lib.php`.
- Ensures the first public-release package does not include a legacy `db/upgrade.php`.

- Uses Moodle's native `core\\activity_dates` API as the source of activity dates.
- Adds per-activity teacher controls for Dates only, Status only, or Dates + status.
- Adds Bootstrap 5 badge and coloured-text status presentations.
- Supports configurable warning and critical deadline thresholds.
- Uses semantic Bootstrap 5 states: info, success, warning, danger, and secondary.
- Keeps Moodle's native date block as a fail-safe if plugin output cannot be rendered.
- Preserves user-specific dates and module-supported overrides supplied by Moodle core.
- Includes English, Brazilian Portuguese, and Spanish language packs in all official 1.0.0 distribution packages, including the Marketplace ZIP.
- Stores presentation settings only; it does not duplicate activity dates or personal data.
