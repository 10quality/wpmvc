---
sidebar_position: 3
---

# Post Models

Post Models are a type of [model](/mvc/models.md) that can be created using the framework.

Out-of-the-box, they provide methods to save, delete, and get information to and from the **WordPress** database without complex development.

The model's attributes (or data columns) can be accessed as object properties.

## Ayuco Commands

### Create Command

Use when the post type related to the model is already defined in WordPress (e.g., pages, posts, attachments).

```bash
php ayuco create model:{model}
```

* `{model}` -> The name of the class model to be created.

### Register Command

Use when a new custom post type needs to be registered and linked to a model (e.g., books, products, artists).

```bash
php ayuco register type:{type} {model} {controller}
```

* `{type}` -> The custom post type to be registered.
* `{model}` -> The name of the class model to be created.
* `{controller}` -> Controller for automated property saving.

## Usage

Add the use statement at the beginning of your PHP files to specify which model you’ll use.

```php
// Definition to use "Post" model.
use MyNamespace\Models\Post;

// Definition to use "Book" model.
use MyNamespace\Models\Book;

// Usage in variables after definition.
$post = Post::find( $post_id );
$book = new Book;
```

## Get

Two main methods to retrieve models loaded with data:

* `find()` — Retrieve an individual record by Post ID.
* `from()` — Retrieve child records from a post parent by parent Post ID.

```php
/**
 * Find and get the post model with ID "1" from database.
 * @return object Post model loaded with data from post "1".
 */
$post = Post::find( 1 );

/**
 * Find and get all attachments related to the previous post from the database.
 * @return array Collection of attachments related to post.
 */
$attachments = Attachment::from( $post->ID );
```

## Save

Call `save()` to insert or update the record in the database.

```php
// First we modify some of the attributes in the model.
$post->post_title = 'My awesome post';
$post->post_content .= ' This is appended to the content.';

// Then we save changes
$post->save();
```

## Delete

Call `delete()` to move the record to the WordPress trash.

```php
$post->delete();
```

To force permanent deletion (no trash), add `$forceDelete` in your model:

```php title="app/Models/Post.php" showLineNumbers
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\PostModel as Model;

class Post extends Model
{
    use FindTrait;
    
    /**
     * Forces database deletions instead of just moving the record to WordPress trash.
     * @var bool
     */
    protected $forceDelete = true;
}
```

## Aliases

The most powerful feature: The $aliases property maps custom aliases to post attributes, meta values, or custom functions. Access them as regular properties.

```php title="app/Models/Post.php" showLineNumbers
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\PostModel as Model;

class Post extends Model
{
    use FindTrait;

    /**
     * Aliases. Mapped against post attributes, meta data or functions.
     * @var array
     */
    protected $aliases = [
        // Alias "title" for post attribute "post_title"
        'title'     => 'post_title',
        // Alias "editor" for meta data with meta key "editor"
        'editor'    => 'meta_editor',
        // Alias "date" for meta data with meta key "publish_date"
        'date'      => 'meta_publish_date',
        // Alias "author" for class function "get_author"
        'author'    => 'func_get_author',
    ];
    
    /**
     * Returns the value used for alias "author".
     * In this example, this function will return the fullname of
     * an author based on meta data stored in the model.
     * @return string
     */
    public function get_author()
    {
        return $this->meta['author_name'].' '.$this->meta['author_lastname'];
    }
}
```

Usage:

```php
$post = Post::find(1);

/**
 * (1) Echo the value stored on "post_title" attribute.
 * (2) Update the value stored on "post_title" attribute.
 */
echo $post->title;
$post->title = 'New title';

/**
 * (1) Echo the meta value stored on meta key "editor".
 * (2) Update the meta value stored on meta key "editor".
 */
echo $post->editor;
$post->editor = 'Wordpress MVC';

/**
 * (1) Echo the meta value stored on meta key "publish_date".
 * (2) Update the meta value stored on meta key "publish_date".
 */
echo $post->date;
$post->date = date('Y-m-d');

/**
 * (1) Echo the returned value of function "get_author".
 * (2) Aliases based on functions are READ-ONLY
 */
echo $post->author;

// Save updates made on model.
$post->save();
```

> **Be aware**
> Aliases mapped to meta data must use prefix **meta_** followed by the meta key.
> Aliases mapped to functions must use prefix **func_** followed by the function name in the class. Function-based aliases are READ-ONLY.

## Meta Data

All metadata loads when a model is retrieved. Access via the `meta` property (READ-ONLY).

```php
/**
 * Use the "meta_key" of choice to access the desired meta value.
 * This property is READ-ONLY; to make meta writable use aliases instead.
 * @var array
 */
$post->meta['meta_key'];
```

> **Is READ-ONLY** — Use aliases to make meta writable.

## Casting

Convert the model to various formats:

```php
// Casts model to array.
$array = $post->to_array();

// Casts model to WP_Post object.
$wp_post = $post->to_post();

// Casts model to json string.
$json = $post->to_json();

// Casts model to json string.
$string = (string)$post;
```
Hide properties from JSON/array/string output:

```php
class Post extends Model
{
    use FindTrait;

    /**
     * Hidden properties. Removed properties/aliases when model
     * is casted into json, string or array.
     * @var array
     */
    protected $hidden = [
        'post_date',
        'password',
    ];
}
```

## Automated Models

Automated models register new post types and simplify meta box editing. They link to a Model Controller.

Supports properties for automation:

```php title="app\Models\Book.php" showLineNumbers
class Book extends Model
{
    use FindTrait;

    /**
     * Post type
     * @var string
     */
    protected $type = 'book';

    /**
     * Controller in charge of automation.
     * @var string
     */
    protected $registry_controller = 'BookController';

    /**
     * Basic registry definition. This sample shows the default settings.
     * @var array
     */
    protected $registry = [
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
    ];

    /**
     * Labels.
     * @var array
     */
    protected $registry_labels = [
        'name'               => 'Books',
        'singular_name'      => 'Book',
        'menu_name'          => 'Books',
    ];
    
    /**
     * WordPress support for during registration.
     * @var array
     */
    protected $registry_supports = [
        'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments',
    ];
    
    /**
     * Rewrite.
     * @var array
     */
    protected $registry_rewrite = [
        'slug' => 'book'
    ];
    
    /**
     * Metabox.
     * @var array
     */
    protected $registry_metabox = [
        'title'             => 'Properties',
        'context'           => 'normal',
        'priority'          => 'high',
    ];
    
    /**
     * Taxonomies.
     * @var array
     */
    protected $registry_taxonomies = [];
}
```

> **Important to know**
> Not all registry properties need to be filled; use only those needed.

## Relationships

Define relationships in 3 ways:

* `has_one` — 1-to-1 (parent)
* `belongs_to` — 1-to-1 (child)
* `has_many` — 1-to-N (parent)

### Has One (has_one)

```php
class Post extends Model
{
    use FindTrait;
    
    /**
     * Aliases.
     * @var array
     */
    protected $aliases = [
        'book_id'   => 'meta_book_id',
    ];

    /**
     * Returns "has_one" relationship.
     * @return object|Relationship
     */
    protected function book()
    {
        return $this->has_one( Book::class, 'book_id' );
    }
}
```

Usage:

```php
$post = Post::find( $post_id );
var_dump( $post->book );
```

Supports external models (e.g., **WooCommerce**):

```php
class Book extends Model
{
    use FindTrait;
    
    /**
     * Aliases.
     * @var array
     */
    protected $aliases = [
        'product_id'   => 'meta_product_id',
    ];

    /**
     * Returns "has_one" relationship with a WooCommerce class model.
     * @return object|Relationship
     */
    protected function product()
    {
        return $this->has_one(
            WC_Product::class,
            'product_id',
            null,               // Method to init in child class
            'wc_get_product'    // Global function used to load class
        );
    }
}
```

### Belongs To (belongs_to)

```php
class Post extends Model
{
    use FindTrait;

    /**
     * Returns "belongs_to" relationship.
     * @return object|Relationship
     */
    protected function parent()
    {
        return $this->belongs_to( Post::class, 'post_parent' );
    }
}
```

### Has Many (has_many)

```php
class Post extends Model
{
    use FindTrait;
    
    /**
     * Aliases.
     * @var array
     */
    protected $aliases = [
        'event_ids' => 'meta_events',
    ];

    /**
     * Returns "has_many" relationship.
     * @return object|Relationship
     */
    protected function events()
    {
        return $this->has_many( Event::class, 'event_ids' );
    }
}
```

> For has_many, the property/alias must be an array of IDs.

Post Models give you powerful, WP-native data handling with minimal code — perfect for custom post types and meta.