---
sidebar_position: 5
---

# Custom Models

**WordPress MVC** (WPMVC) allows you to work with custom database tables using the traits included in the `10quality/wp-query-builder` package.

These traits provide a lightweight model layer on top of the Query Builder, enabling structured access to custom tables without introducing a full ORM.

This feature requires the `10quality/wp-query-builder` package to be installed.

## Installation

If you have not installed the Query Builder yet:

```bash
composer require 10quality/wp-query-builder
```

### Creating a Custom Model

To create a model for a custom table, define a PHP class and include the model trait provided by the package.

Example:

```php title="app/Models/Book" showLineNumbers
<?php

namespace App\Models;

use TenQuality\WP\Database\Abstracts\DataModel as Model;
use TenQuality\WP\Database\Traits\DataModelTrait;

class Book extends Model
{
    use DataModelTrait;

    /**
     * Table name (without WordPress prefix).
     *
     * @var string
     */
    protected static $table = 'books';
}
```

## Table Naming

The `$table` property should contain the table name without the WordPress database prefix. The builder automatically resolves the correct prefixed table name using $wpdb.

If your table is:

`wp_books`

You should define:

```php
protected static $table = 'books';
```

## Retrieving Records

Once defined, you can use the static query interface provided by the trait.

### Get All Records

```php
$books = Book::all();
```

### Find by ID

```php
$book = Book::find(123);
```

### Filtering

```php
$books = Book::where([
    'name' => 'ABC',
    'limit' => 5,
]);
```

#### Using Query Builder

```php
$books = Book::builder()
    ->where('name', 'ABC')
    ->where('status', 'published')
    ->get( ARRAY_A );
```

## Inserting Records

```PHP
Book::insert([
    'title'  => 'Example Book',
    'status' => 'draft',
]);
```

## Updating Records

```php
Book::builder()
    ->where(['id' => 5])
    ->set([
        'status' => 'published',
    ])
    ->update();
```

Or:

```php
$book = Book::find(5);
$book->status = 'published';
$book->save();
```

## Deleting Records

```php
Book::builder()
    ->where(['id' => 5])
    ->delete();
```

Or:

```php
$book = Book::find(5);
$book->delete();
```

## Accessing the Underlying Builder

If needed, you can access the underlying query builder directly:

```php
$query = Book::builder();

$query->select('*')->get();
```

This allows full access to all Query Builder methods while keeping your custom table logic encapsulated inside a model class.

## When to Use Custom Table Models

Custom models are recommended when:

* Working with plugin-specific tables
* Managing structured data not stored as posts or post meta
* Building reporting or data-driven features
* Replacing heavy postmeta queries with optimized custom tables

They provide a clean, testable abstraction while remaining lightweight and WordPress-compatible.