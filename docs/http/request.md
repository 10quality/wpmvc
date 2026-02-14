---
sidebar_position: 1
---

# Request

The **Request** class in WordPress MVC (WPMVC) is a helper for retrieving and sanitizing request data from:

* WordPress query variables (`$wp_query->query_vars`)
* `$_POST`
* `$_GET`

It simplifies access to inputs, applies sensible defaults, and applies **sanitization** before returning values.

## Usage

Import the class at the top of your file:

```php
use WPMVC\Request;
```

Get a single input value

```php
$value = Request::input( 'name', $default_value );
```

If the key doesn’t exist in any request source, the `$default_value` is returned.

To **clear the source** so that the value can't be re-read (e.g., in nonce verification), pass true:

```php
$nonce = Request::input( 'my_nonce', null, true );
```

### Get all inputs

To retrieve all request variables (from GET, POST, and WordPress query vars):

```php
$request = Request::all();
```

You can then access values by key:

```php
echo $request[ 'username' ];
```

## Sanitation

By default, the `Request` class **sanitizes** all values based on their detected type:

| Input Type | Behavior |
| ---------- | -------- |
| Numeric without dot | `intval()` |
| Numeric with decimal | `floatval()` |
| "true" / "false" strings | Converted to boolean |
| Valid email | `sanitize_email()` |
| String | sanitize_text_field() |
| Array | Recursively sanitized via `sanitize_array()` |

You can turn off sanitization or provide a custom sanitization callable:

### Disable sanitation

```php
$value = Request::input( 'key', null, false, false );
```

Custom sanitizer
```php
$value = Request::input( 'key', null, false, 'my_custom_sanitizer' );
```

Also works with `all()`:
```php
$all = Request::all( 'my_custom_sanitizer' );
```

## API Reference

`public static input( $key, $default = null, $clear = false, $sanitize = true )`

Retrieve a single input value from query_vars, POST, or GET.

**Parameters**

| Argument | Type | Description |
| --- | --- | ---- |
| `$key` | `string` | Name of the input to retrieve |
| `$default` | `mixed` | Value to return if input not found |
| `$clear` | `bool` | Remove the item from source after reading |
| `$sanitize` | `bool`,`string` | Returns: "mixed" — sanitized value or default |

`public static all( $sanitize = true )`

Return an array of all inputs from GET, POST, and query vars.

**Parameters**

| Argument | Type | Description |
| --- | --- | ---- |
| `$sanitize` | `bool`,`string` | Returns: array — key/value list of all data |

### Detailed behavior

* If `$sanitize` is `false`, returns raw value.
* If `$sanitize` is `true` or no callable provided, applies default sanitizers based on type.
* Email and string sanitization can be filtered via WP filters:
  * `wpmvc_request_sanitize_email`
  * `wpmvc_request_sanitize_string`

## Example Patterns

Get a blog form field with fallback
```php
$username = Request::input( 'username', 'guest' );
```

Retrieve raw (unsanitized) request data
```php
$rawData = Request::all( false );
```

Access and clear a query var
```php
$id = Request::input( 'id', null, true );
```