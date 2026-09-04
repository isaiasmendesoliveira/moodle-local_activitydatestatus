# Moodle Marketplace submission — Activity Date Status 1.0.0

This file contains copy-ready metadata for the first public listing.

## Plugin identity

- **Name:** Activity Date Status
- **Frankenstyle:** `local_activitydatestatus`
- **Plugin type:** Local plugin
- **Release:** 1.0.0
- **Maturity:** Stable
- **Minimum Moodle:** 4.5
- **Declared support:** Moodle 4.5–5.2
- **License:** GNU GPL v3 or later
- **Price:** Free (recommended for this community plugin)

## Short description

Activity Date Status turns Moodle's native activity dates into clear exact-date and relative-status indicators on the course page. Teachers can choose dates only, status only, or both, with Bootstrap 5 badges and configurable warning and critical thresholds.

## Full description

Activity Date Status enhances the presentation of activity dates on Moodle course pages without changing Moodle's scheduling or access logic.

The plugin uses Moodle's native `core\\activity_dates` API as its single source of activity dates. Teachers can enable the indicator individually for each activity or resource and choose whether to display exact dates, a relative status, or both. Relative statuses use semantic Bootstrap 5 visual states and optional SVG icons to make upcoming, available, warning, critical, overdue, and closed states easier to recognise.

Key features:

- per-activity teacher control;
- Dates only, Status only, and Dates + status modes;
- Bootstrap 5 badge or coloured-text status appearance;
- configurable warning and critical thresholds per activity;
- site defaults that teachers can override;
- user-specific dates and module-supported overrides supplied by Moodle core;
- fail-safe rendering that preserves Moodle's native date display if plugin output cannot be generated;
- no external services or additional runtime dependencies;
- no storage of personal data.

The plugin does not create, copy, or modify activity dates. Opening dates, closing dates, due dates, overrides, and access rules remain controlled by Moodle and the activity module.

## Installation

1. Download the `activitydatestatus` ZIP package.
2. Go to **Site administration → Plugins → Install plugins**.
3. Upload the ZIP and complete Moodle's plugin validation.
4. Visit **Site administration → Notifications** to complete installation.
5. Optional: configure site defaults under **Site administration → Plugins → Local plugins → Activity Date Status**.
6. Edit an activity/resource and enable **Display date and deadline indicator**.

No command-line, Composer, API key, or external service is required.

## Reviewer test scenario

1. Create a course with activity dates enabled or disabled; either is acceptable.
2. Create a Quiz or Assignment with a future closing/due date.
3. In the activity settings, enable **Display date and deadline indicator**.
4. Select **Dates + status** and **Bootstrap 5 badge**.
5. Set warning threshold to 48 hours and critical threshold to 12 hours.
6. Open the course page and verify that the activity displays exact dates and a relative badge.
7. Change the display mode to **Status only** and confirm that the native activity-date block is replaced only after plugin output is rendered.

## Privacy

The plugin stores presentation settings per course module. It does not store personal data and does not duplicate activity dates. User-specific dates are obtained at render time from Moodle core.

## Accessibility

- Every state includes text; colour is not the sole indicator.
- SVG icons are decorative and hidden from assistive technologies.
- The plugin inherits Moodle/theme typography and uses Bootstrap semantic utilities.

## Repository and tracker

After creating the public GitHub repository, use:

- **Repository:** `https://github.com/<account>/moodle-local_activitydatestatus`
- **Issue tracker:** `https://github.com/<account>/moodle-local_activitydatestatus/issues`
- **Documentation:** repository README / `docs/`

## Suggested screenshots

Prepare at least these screenshots before submission:

1. **Course page — status badges:** several activities showing success, warning, and danger states.
2. **Activity settings:** the complete “Date and deadline indicator” section.
3. **Display modes:** Dates only, Status only, and Dates + status examples.
4. **Site defaults:** Activity Date Status administration settings page.

Use real Moodle screenshots and avoid including private student information.

## Included languages

The submitted package intentionally includes three complete language packs:

- English (`en`);
- Brazilian Portuguese (`pt_br`);
- Spanish (`es`).

These translations are distributed with the plugin so the first public release is immediately usable in all three languages. The Marketplace listing should explicitly state that the ZIP includes these three translations. Future community translations can still be maintained through Moodle's standard translation workflow.
