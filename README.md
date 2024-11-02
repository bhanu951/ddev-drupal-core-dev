# ddev-core-dev

This is a DDEV addon for doing Drupal core development.

We're in #ddev-for-core-dev on [Drupal Slack](https://www.drupal.org/community/contributor-guide/reference-information/talk/tools/slack) (but please try and keep work and feature requests in Issues where it's visible to all 🙏)

## Installation

The recommended way to set up Drupal core for development is with the Composer
project template `joachim-n/drupal-core-development-project`. This addon can
also be used with Drupal installed directly on a git clone of core.

``` bash
# Use either of step 1A or 1B.
# 1A: Install with Composer project template (recommended)
# If you already installed a project using the template following the
# instructions in its README then skip to step 2.
ddev config --project-type=drupal --docroot=web --php-version=8.3
ddev start
ddev composer create joachim-n/drupal-core-development-project
ddev config --update
ddev restart

# 1B: Install directly on a git clone (advanced)
git clone --branch=11.x https://git.drupalcode.org/project/drupal.git drupal
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

### DDEV Commands Usage

```bash
ddev phpcs core/modules/user/src/RegisterForm.php (from repos/drupal directory)
ddev phpcbf core/modules/user/src/RegisterForm.php (from repos/drupal directory)
ddev phpstan core/modules/user/src/RegisterForm.php (from repos/drupal directory)
ddev phpunit core/modules/user/tests/src/Functional/UserAdminTest.php (from repos/drupal directory)
ddev code-check (ddev equivalent of running sh core/scripts/dev/commit-code-check.sh)
ddev cspell-check (Checks for forbidden and new words which are not present in dictonary)
ddev install (Installs new site)
ddev drush [arguments] (from project root)
```

### PHPUnit tests

```bash
# Run PHPUnit tests
ddev phpunit core/modules/sdc
```

### Nightwatch tests

You can watch Nightwatch running in real time at https://drupal.ddev.site:7900
for Chrome and https://drupal.ddev.site:7901 for Firefox. The password is
"secret". YMMV using Firefox as core tests don't currently run on it.

Only core tests

```bash
ddev nightwatch --tag core
```

Skip running core tests

```bash
ddev nightwatch --skiptags core
```

Run a single test

```bash
ddev nightwatch tests/Drupal/Nightwatch/Tests/exampleTest.js
```

a11y tests for both the admin and default themes

```bash
ddev nightwatch --tag a11y
```

a11y tests for the admin theme only

```bash
ddev nightwatch --tag a11y:admin
```

a11y tests for the default theme only

```bash
ddev nightwatch --tag a11y:default
```

a11y test for a custom theme used as the default theme

```bash
ddev nightwatch --tag a11y:default --defaultTheme bartik
```

a11y test for a custom admin theme

```bash
ddev nightwatch --tag a11y:admin --adminTheme seven
```

### Core Linting

This will run static tests against core standards.

``` bash
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
