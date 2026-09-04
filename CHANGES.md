# Changelog

## 1.0.0 - 2026-09-04

Initial public release of **Activity Date Status**.

CI packaging refinements for the 1.0.0 release candidate:

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
