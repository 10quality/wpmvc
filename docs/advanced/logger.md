---
sidebar_position: 2
---

# Logger

The Logger component provides a simple static interface to record messages, debugging values, and errors into a log file. It is a lightweight wrapper around an internal logging driver and is used across the WPMVC framework to monitor application state, errors, and runtime data.

Log files are typically stored under:

```bash
{wp-content}/wpmvc/log
```

## Importing the Logger

Include the Logger class via a use statement:

```php
use WPMVC\Log;
```

## Logging Methods

The following static methods are available for writing to the log:

### info

`Log::info( string $message )`

Record an informational message:

```php
Log::info( 'User settings updated' );
```

Useful for general messages about application state.

### debug

`Log::debug( string $message, mixed $values = null )`

Log debugging details:

```php
Log::debug( 'Query result', $results );
```

If `$message` is not a string, it will default to 'value'.

`$values` can be any mix of strings, arrays, or objects.

### error

`Log::error( mixed $e )`

Log an exception or error:

```php
try {
    // risky operation
} catch ( Exception $e ) {
    Log::error( $e );
}
```

Errors are passed through to the configured logger instance for formatting and writing.

## Under the Hood

* Internally, the Log class manages a single shared logger instance:
* A protected static `\$path` holds the log storage directory.
* A protected static `\$logger` references the actual logging driver (e.g., a Logger object).
* On first call to any logging method, the Logger instance is created with the stored path.
* This ensures all logs within a request cycle use the same underlying logger.

The logger uses an internal logging driver class (Logger) to perform the actual writes.

Log levels (info, debug, error) behave consistently with typical PSR-style loggers.