# Contributing

Contributions to Activity Date Status are welcome.

## Development requirements

- Moodle 4.5 or later.
- A supported PHP version for the Moodle branch under test.
- Moodle's standard Grunt tooling for AMD source changes.

## Coding standards

- Follow Moodle coding style.
- Keep PHP, JavaScript, comments, and identifiers in English.
- Do not hard-code user-facing strings; use Moodle language strings.
- Keep CSS selectors scoped with the `local-activitydatestatus` prefix.
- Do not bypass Moodle's native date/access APIs.

## Tests

Before opening a pull request, run the relevant Moodle Plugin CI checks. GitHub Actions performs automated PHP linting, code checking, validation, Grunt checks, and PHPUnit tests.

When modifying `amd/src/course.js`, rebuild the AMD artifacts with Moodle's Grunt workflow before committing. The repository must contain both `amd/build/course.min.js` and `amd/build/course.min.js.map`.

The preferred option is the **Rebuild Moodle AMD** GitHub Actions workflow. It builds with Moodle 5.2 (the highest supported branch) and commits the canonical generated files automatically. For local development, run `npx grunt amd` from the plugin's `amd` directory inside a Moodle 5.2 development tree.

## Pull requests

Please include:

- a concise description of the problem and solution;
- steps to test the change;
- screenshots for visual changes;
- tests where practical.
