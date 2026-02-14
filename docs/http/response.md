---
sidebar_position: 2
---

# Response

The **Response** class provides a clean way to send output in WordPress MVC.

This class simplifies and standardizes HTTP responses within WPMVC, particularly for JSON/Ajax endpoints. It tracks success state, errors, data, and additional output information.

## Overview

The `Response` class:
* Collects errors and tracks whether a response passes or fails.
* Simplifies rendering a JSON response.
* Offers helpers to serialize response data and output it.

## Class Signature

```php
use WPMVC\Response;
```

By default:
```php
$response = new Response;
```

This initializes a response marked not successful (default success = false).

## Properties

The core properties include:

| Property | Type | Description |
| --- | --- | --- |
| `errors` | `array` | Stored errors keyed by field/name |
| `message` | `string` | Optional response message |
| `success` | `bool` | Whether the response is successful |
| `data` | `mixed` | Additional response data |
| `redirect` | `string` | URL for redirects |
| `id` | `mixed` | Primary key or last inserted ID |
| `query` | `array` | Query information/meta |

All properties are accessible via PHP magic getters/setters, including:

* `$response->passes` → true when no errors.
* `$response->fails` → true when errors exist.

## Setting Values

### Errors

Add errors via:

```php
$response->error( 'field_name', 'Error message' );
```

This stores the error under the given key.

## Output Formats

`to_array()`

Returns a structured array:

```php
[
  'error'  => bool,
  'status' => int,
  'message' => (optional),
  'redirect' => (optional),
  'errors' => (optional list),
  'data' => (optional),
  'query' => (optional),
  'id' => (optional),
]
```

The `'status'` defaults to 200 if `$success === true`, otherwise `500`.

## String / JSON Responses

### Cast to string

This returns JSON with JSON_NUMERIC_CHECK:

```php
(string)$response
```

Equivalent to:

```php
$response->to_json()
```

## Raw JSON Output

Render and exit with:

```php
$response->json();
```

This sets the `Content-Type: application/json` header, prints **JSON**, and exits.

## Example Usage

Here’s how the old documentation showed usage in an Ajax context:

```php
function ajax_request() {
    $response = new Response;

    $id = Request::input( 'id' );
    $name = Request::input( 'name' );

    if ( empty( $id ) ) {
        $response->error( 'id', 'Required.' );
    }
    if ( empty( $name ) ) {
        $response->error( 'name', 'Required.' );
    }

    // Check validation
    if ( $response->fails ) {
        // Handle failure
    }

    if ( $response->passes ) {
        $response->success = true;
        $response->message = 'Request processed!';
        $response->data = $someData;
    }

    $response->json();
}
```