---
sidebar_position: 1
---

# Query Builder

**WordPress MVC** (WPMVC) does not include an ORM or expressive database layer out of the box, but it fully supports using an optional fluent SQL query builder for structured database interactions. The recommended package for this purpose is `10quality/wp-query-builder`, a standalone Composer library that provides a fluent, chainable API to build and execute SQL queries on top of WordPress's database layer.

## Installation

Install the package using Composer:

```bash
composer require 10quality/wp-query-builder
```

This adds a lightweight query builder that can be used anywhere in your theme or plugin code.

## Basic Usage

Once installed, you can start building and executing queries fluently:

```php
use TenQuality\WP\Database\QueryBuilder;

// Create a builder instance (helper function may be available)
$books = wp_query_builder()
    ->select( 'ID' )
    ->select( 'post_name AS name' )
    ->from( 'posts' )
    ->where( ['post_type' => 'book'] )
    ->get();

foreach ( $books as $book ) {
    echo $book->ID;
    echo $book->name;
}
```

This example selects `ID` and `name` from the `posts` table where `post_type` is `book`, returning an array of standard objects with the result rows.

## Fluent API Features

The query builder offers a range of methods to construct SQL statements in a readable, chainable fashion:

* `select()` — specify one or more columns
* `from()` — set the table to query
* `where()` — add filter conditions
* `get()` — execute and return all results

Additional operations such as joins, grouping, ordering, and raw expressions are supported.

### Examples

#### Filtering with Multiple Conditions

```php
$books = wp_query_builder()
    ->select( '*' )
    ->from( 'posts' )
    ->where( [
        'post_type'   => 'book',
        'post_status' => 'publish',
    ] )
    ->get();
```

#### Ordering Results

```php
$books = wp_query_builder()
    ->select( '*' )
    ->from( 'posts' )
    ->where( ['post_type' => 'book'] )
    ->orderBy( 'post_date', 'DESC' )
    ->limit(5)
    ->get();
```

## Scope and Philosophy

Like Laravel's Eloquent Query Builder, this package is independent of WPPMVC core, meaning it won’t conflict with WordPress's native APIs. It simply wraps WordPress's database access in a more expressive syntax. You can use it for:

* Selecting records from custom tables
* Filtering with where conditions
* Sorting and limiting result sets
* Joining related tables

For advanced use cases or model integration, consider encapsulating builder logic within a custom class or wrapper.