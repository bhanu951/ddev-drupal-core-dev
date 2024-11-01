# ddev-core-dev

This is a DDEV addon for doing Drupal core development.

We're in #ddev-for-core-dev on [Drupal Slack](https://www.drupal.org/community/contributor-guide/reference-information/talk/tools/slack) (but please try and keep work and feature requests in Issues where it's visible to all 🙏)

## Installation

The recommended way to set up Drupal core for development is with the Composer
project template `joachim-n/drupal-core-development-project`. This addon can
also be used with Drupal installed directly on a git clone of core.

```
# 1A: Install with Composer project template (recommended)
# If you already installed a project using the template following the
# instructions in its README then skip to step 2.
ddev config --project-type=drupal --php-version=8.3
ddev start
ddev composer create joachim-n/drupal-core-development-project
ddev config --update
ddev restart

# 1B: Install directly on a git clone
git clone https://git.drupalcode.org/project/drupal.git drupal
cd drupal
ddev config --disable-settings-management
ddev start
ddev composer install

# 2. Install this add-on
ddev add-on get justafish/ddev-drupal-core-dev

# 3. Install drupal
ddev drush si -y --account-pass==admin
```

## Running tests

### PHPUnit tests

```
# Run PHPUnit tests
ddev phpunit web/core/modules/sdc
```

### Nightwatch tests

You can watch Nightwatch running in real time at https://drupal.ddev.site:7900
for Chrome and https://drupal.ddev.site:7901 for Firefox. The password is
"secret". YMMV using Firefox as core tests don't currently run on it.

Only core tests
```
ddev nightwatch --tag core
```

Skip running core tests
```
ddev nightwatch --skiptags core
```

Run a single test
```
ddev nightwatch tests/Drupal/Nightwatch/Tests/exampleTest.js
```

a11y tests for both the admin and default themes
```
ddev nightwatch --tag a11y
```

a11y tests for the admin theme only
```
ddev nightwatch --tag a11y:admin
```

a11y tests for the default theme only
```
ddev nightwatch --tag a11y:default
```

a11y test for a custom theme used as the default theme
```
ddev nightwatch --tag a11y:default --defaultTheme bartik
```

a11y test for a custom admin theme
```
ddev nightwatch --tag a11y:admin --adminTheme seven
```

### Core Linting

This will run static tests against core standards.

```
ddev drupal lint:phpstan
ddev drupal lint:phpcs
ddev drupal lint:js
ddev drupal lint:css
ddev drupal lint:cspell
# CSpell against only modified files
ddev drupal lint:cspell --modified-only
```

You can run all linting with `ddev drupal lint`, or with fail-fast turned on:
`ddev drupal lint --stop-on-failure`
