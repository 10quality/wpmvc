---
sidebar_position: 15
---

# Testing

**WordPress MVC** (WPMVC) includes built-in support for unit testing using PHPUnit integrated with the **WordPress Test Suite**.

The framework simplifies setting up the testing environment and generating test cases using the Ayuco CLI tool.

## Requirements

To run tests, the following components are required:

* **PHPUnit** – A PHP unit testing framework.
* **WordPress Test Suite** – The official test library provided by WordPress that PHPUnit uses to run WordPress-level tests.
* **WP testing config file** – A configuration file similar to `wp-config.php` that sets up the testing environment (database connection, WordPress path, theme, etc).
* **phpunit.xml** – PHPUnit configuration file in your project root defining where tests and bootstrap files are located.
* **phpunit.json** (optional) – WPMVC's test config to specify suite locations and where to find the WordPress Test Suite.

## Setup

WPMVC leverages the Ayuco CLI to streamline testing setup.

Run:

```bash
php ayuco setup tests
```

This command starts a setup wizard that will:

* Download **PHPUnit** (if not already installed).
* Download the **WordPress Test Suite**.
* Generate appropriate configuration files in your project.
* Create a `/tests` directory in your project root.

After completion, your project will be ready for running automated tests.

## Creating Test Cases

WPMVC supports generating PHPUnit test files via Ayuco commands.

Use:

```bash
php ayuco create test:{handler}
```

* `{handler}` -> Name of the test case, e.g. `Hooks`. Or test case plus method, e.g. `Hooks@test_yolo_filter`.

Examples:

```bash
php ayuco create test:Hooks
php ayuco create test:Hooks@test_yolo_filter
```

This will generate a file like:

```bash
/tests/cases/HooksTest.php
```

…and inside it, a method `test_yolo_filter()` ready for assertions.

## Writing Tests

Generated test classes should extend the WordPress test base class (`WP_UnitTestCase`) to access helper methods and assertions provided by the **WordPress Test Suite**.

Example:

```php title="tests/cases/HooksTest.php"
class HooksTest extends WP_UnitTestCase
{
    public function test_yolo_filter()
    {
        // Execute filter
        $string = apply_filters( 'yolo', 'A string value' );

        // Assert expectation
        $this->assertEquals( 'A string value [YOLO]', $string );
    }
}
```

## Running Tests

With PHPUnit installed and your test suite configured, run all tests from your project root:

```dash
./vendor/bin/phpunit
```

This will execute all test cases in your /tests directory and output results.

## Notes

* The setup wizard organizes and bootstraps both **PHPUnit** and the **WordPress Test Suite** so you can start writing tests quickly.
* Tests can cover both framework utilities (hooks, helpers, models) and application code that integrates with WordPress core features.
* The testing configuration files (`phpunit.xml` and `phpunit.json`) let you customize paths, bootstrap scripts, and suites.