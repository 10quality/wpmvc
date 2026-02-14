---
sidebar_position: 7
---

# Comment Models

Comment Models are a type of [model](/mvc/models.md) that can be created using the framework.

Comment Models are related to **WordPress'** comments (and commentmeta), perfect for building comment systems, reviews, threaded discussions, ratings, or custom feedback features.

## Model Functionality

Out-of-the-box, Comment Models provide methods to save, delete, and retrieve information to and from the **WordPress** database without complex development.

The model's attributes (or data columns) can be accessed as object properties.

## Ayuco Command

### Create command

```bash
php ayuco create commentmodel:{model}
```

* `{model}` -> The name of the class model to be created.

## Usage

Add the use statement at the beginning of your PHP files to specify which model you’ll use in your code.

```php
// Definition to use "Review" model (comment model).
use MyNamespace\Models\Review;

// Find record by ID.
$review = Review::find( $comment_id );

// Create new record
$review = new Review;

// Access comment properties
echo $review->comment_content;
echo $review->comment_author;
echo $review->comment_author_email;
echo $review->comment_ID;
```

## Get

Use the `find()` method to retrieve an individual record. Pass by a Comment ID as a parameter.

```php
$review = Review::find( 123 );
```

## Save

Saving the information of a model is a piece of cake. Simply call the `save()` method after changing its attributes. This will insert or update the record in the database.

```php
$review->comment_content .= ' Updated review!';
$review->rating = 4.5;  // Custom meta field
$review->save();
```

## Delete

Call the `delete()` method to delete the comment record.

```php
$review->delete();
```

## Aliases

Arguably, the most powerful feature in a model. The `$aliases` property serves as a mapping tool between custom aliases and comment attributes, meta values, and/or custom functions. Defined aliases can be later accessed as regular properties in a loaded model.

## Code Samples

### Definition sample

```php title="app/Models/Review.php" showLineNumbers
use WPMVC\MVC\Traits\FindCommentTrait;
use WPMVC\MVC\Models\CommentModel as Model;

class Review extends Model
{
    use FindCommentTrait;

    /**
     * Aliases.
     * Mapped against comment attributes, meta data or functions.
     * @var array
     */
    protected $aliases = [
        // Alias "content" for comment attribute "comment_content"
        'content'   => 'comment_content',
        // Alias "rating" for meta data with meta key "rating"
        'rating'    => 'meta_rating',
        // Alias "stars" for class function "get_stars_display"
        'stars'     => 'func_get_stars_display',
    ];

    /**
     * Returns the value used for alias "stars".
     * @return string HTML stars display
     */
    public function get_stars_display()
    {
        $stars = (int) $this->rating;
        return str_repeat('★', $stars) . str_repeat('☆', 5 - $stars);
    }
}
```

### Usage sample

```php
$review = Review::find( 123 );

/**
 * (1) Echo the value stored on "comment_content" attribute.
 * (2) Update the value stored on "comment_content" attribute.
 */
echo $review->content;
$review->content = 'Great product!';

/**
 * (1) Echo the meta value stored on meta key "rating".
 * (2) Update the meta value stored on meta key "rating".
 */
echo $review->rating;
$review->rating = 4.8;

/**
 * (1) Echo the returned value of function "get_stars_display".
 * (2) Aliases based on functions are READ-ONLY
 */
echo $review->stars;

// Save updates made on model.
$review->save();
```

**Be aware**

Aliases mapped to **meta data** must be defined using prefix `meta_` followed by the meta key.

Aliases mapped to **functions** must be defined using prefix `func_` followed by the name of the function in the class. Functions based aliases are **READ-ONLY**.

## Meta Data

All metadata is loaded when a model is retrieved from the database. Access via the meta property.

```php
/**
 * Use the "meta_key" of choice to access the desired
 * meta value. This property is READ-ONLY; to make meta writable use aliases instead.
 * @var array
 */
$review->meta['meta_key'];
```

### Is READ-ONLY

Use aliases to make meta writable.

## Casting

The model can be cast (converted) into multiple data types.

```php
// Casts model to array.
$array = $review->to_array();

// Casts model to json string.
$json = $review->to_json();

// Casts model to json string.
$string = (string)$review;
```

To hide properties (attributes or aliases) from appearing on JSON or array formats (when casting), add the `$hidden` property inside your model class.

```php title="app\Models\Review.php"
class Review extends Model
{
    use FindCommentTrait;

    /**
     * Hidden properties.
     * Removed properties/aliases when model
     * is casted into json, string or array.
     * @var array
     */
    protected $hidden = [
        'comment_author_IP',
        'comment_agent',
    ];
}
```

Comment Models give you clean, object-oriented access to WordPress comments — ideal for reviews, feedback forms, threaded discussions, or rating systems — with full support for meta fields, custom aliases, and the framework's powerful trait-based features.