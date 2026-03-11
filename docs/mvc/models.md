---
sidebar_position: 2
title: Models
description: Learn how to use models in the WordPress MVC Framework (WPMVC) to manage data and business logic when building structured WordPress plugins and themes.
keywords: [wordpress mvc model, wordpress plugin model example, wordpress mvc theme development, wordpress mvc framework models, mvc data layer wordpress, wordpress plugin and theme architecture]
---

<head>
  <title>WordPress MVC Models – Data Layer for Plugins and Themes</title>
</head>
---

# Models

In WordPress MVC (WPMVC), **Models** represent and manage your data objects. They handle interaction with the database — whether custom tables or WordPress core tables — providing a clean, object-oriented layer for fetching, saving, updating, and deleting records.

WPMVC is designed with WordPress in mind, so it offers **specialized model types** for the most common core data sources:
- Posts (and postmeta)
- Users (and usermeta)
- Terms/Taxonomies (terms, termmeta)
- Options
- Comments (and commentmeta)

For custom data, you create models backed by your own tables. This eliminates raw `$wpdb` queries in most cases and promotes reusable, testable code.

## Key Benefits of Models in WPMVC

- Automatic handling of WordPress core tables and meta data.
- Consistent CRUD operations across data types.
- Easy integration with [controller](mvc/controllers.md) and [views](mvc/views.md).
- Ayuco scaffolding generates boilerplate quickly.
- Extensible for validations, relationships, and custom logic.

## Storage Path

Views are stored under the project’s view directory. For example:

```bash
[project]/app/Models/
```

## Creating Models with Ayuco

Use Ayuco to generate the right model type based on your data source. Run these from your project root.

### 1. Post Models (for wp_posts + wp_postmeta)

Ideal for custom post types (books, events, products) or extending built-in types (post, page).

- For an existing post type:
```bash
php ayuco create model:Post
```

For a new custom post type (also registers CPT, model, controller):

```bash
php ayuco register type:book Book BookController
```

This creates `app/Models/Book.php` (extends a base post model) and wires it to the CPT.

### 2. User Models (for wp_users + wp_usermeta)

```bash
php ayuco create usermodel:User
```

Generates a model for user data, useful for custom user profiles or roles.

### 3. Option Models (for wp_options table)

Great for plugin settings stored as serialized arrays or single values.

```bash
php ayuco create optionmodel:MyApp my_app_settings
```

The second argument is the option name (e.g., `'my_app_settings'`).

### 4. Term Models (for wp_terms + wp_termmeta)

For custom taxonomies (e.g., book publishers, genres).

```bash
php ayuco create termmodel:BookPublisher book_publisher
```

The second argument is the taxonomy slug.

### 5. Comment Models (for wp_comments + wp_commentmeta)

```bash
php ayuco create commentmodel:BookNote
```

Useful for review systems or threaded notes.

## Basic Model Structure

Generated models typically look like this (example for a custom or post model):

```php title="app/Models/Book.php" showLineNumbers
<?php

namespace MyAwesomePlugin\Models;

use WPMVC\MVC\Models\PostModel as Model;
use WPMVC\MVC\Traits\FindTrait;

class Book extends Model
{
    use FindTrait;

    protected $type = 'book';
}
```

## Working with Models in Code

In controllers or elsewhere:

```php
// Fetch a single book (post type)
$book = Book::find(123);  // By ID

// Create / save
$new_book = new Book();
$new_book->post_title = 'New Title';
$new_book->save();

// Update
$book->price = 29.99;
$book->save();

// Delete
$book->delete();
```

For option models:

```php
$settings = MyApp::get();  // Loads from wp_options
$settings->api_key = 'new-key';
$settings->save();
```

## Advanced Usage Tips

* Meta Handling: Core-backed models (posts, users, etc.) automatically sync meta fields as object properties.
* Relationships: Define in the model (e.g., `has_many`, `belongs_to`) if supported — check your version or extend manually.
* Callbacks/Validations: Add methods like before_save(), after_create() for logic.

Models are the data foundation of your WPMVC project — by leveraging WordPress core models out-of-the-box, you avoid reinventing the wheel and focus on custom business logic.