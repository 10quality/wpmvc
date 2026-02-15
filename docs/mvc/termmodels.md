---
sidebar_position: 5
---

# Term Models

Term Models are a type of [model](/mvc/models.md) that can be created using the framework.

Term Models are related to **WordPress'** terms and taxonomies (tags, post type categories and other), it suits perfectly for term data customizations.

## Model Functionality

Out-of-the-box will provide methods to save, delete and get information to and from **WordPress** database without any complex development needed.

The model's attributes (or data columns) can be accessed as object properties.

## Ayuco Command

### Create command

```bash
php ayuco create termmodel:{model} {taxonomy}
```

* `{model}` -> The name of the class model to be created.
* `{taxonomy}` -> (Optional) The taxonomy related to the model. Do not use this argument if the model will be a generic model that handles different taxonomies.

## Usage

Add the `use` statement at the beginning of your PHP files to specify which model you’ll use in your code.

### Definition to use "MyTerm" model.

```php
use MyNamespace\Models\MyTerm;
```

### Find record by ID.

```php
$term = MyTerm::find( $term_id );
```

### Find record by ID and taxonomy.

```php
$term = MyTerm::find( $term_id, $taxonomy );
```

### Find record by slug.

```php
$term = MyTerm::find_by_slug( $term_slug );
```

### Find record by slug and taxonomy.

```php
$term = MyTerm::find_by_slug( $term_slug, $taxonomy );
```

### Create new record

```php
$term = new MyTerm;
```

### Access category properties

```php
echo $term->term_id;
echo $term->slug;
echo $term->name;
echo $term->term_taxonomy_id;
```

## Get

Use the `find()` method to retrieve an individual record. Pass by a Term ID and a Taxonomy as parameters. Use the `find_by_slug()` method to retrieve an individual record. Pass by a Slug and a Taxonomy as parameters.

## Save
Saving the information of a model is a piece of cake. Simply call the `save()` method after changing its attributes. This will insert or update the record in the database.

## Delete

Deleting a model is easy, simply call the `delete()` method to delete the record.

## Aliases

Arguably, the most powerful feature in a model. The `$aliases` property serves as a mapping tool between custom aliases and term attributes, meta values and/or custom functions. Defined aliases can be later accessed as regular properties in a loaded model.

## Code Samples

### Definition sample

```php title="app/Models/MyTerm.php" showLineNumbers
use WPMVC\MVC\Traits\FindTermTrait;
use WPMVC\MVC\Models\TermModel as Model;

class MyTerm extends Model
{
    use FindTermTrait;

    /**
     * Aliases.
     * Mapped against category attributes, meta data or functions.
     * @var array
     */
    protected $aliases = [
        // Alias "ID" for term attribute "term_id"
        'ID'        => 'term_id',
        // Alias "color" for meta data with meta key "color"
        'color'     => 'meta_color',
        // Alias "css_color" for class function "get_css"
        'css_color' => 'func_get_css',
    ];

    /**
     * Returns the values used for alias "css_color".
     * @return string
     */
    public function get_css()
    {
        switch ( $this->color ) {
            case 'white':
                return '#fff';
            case 'red':
                return '#f00';
            case 'black':
                return '#000';
        }
        return 'transparent';
    }
}
```

### Usage sample

```php
$term = MyTerm::find( 1 );

/**
 * (1) Echo the value stored on "name" attribute.
 * (2) Update the value stored on "name" attribute.
 */
echo $term->name;
$term->name = 'New name';

/**
 * (1) Echo the meta value stored on meta key "color".
 * (2) Update the meta value stored on meta key "color".
 */
echo $term->color;
$term->color = 'white';

/**
 * (1) Echo the returned value of function "get_css".
 * (2) Aliases based on functions are READ-ONLY
 */
echo $term->css_color;

// Save updates made on model.
$term->save();
```

**Be aware**

Aliases mapped to **meta data** must be defined using prefix `meta_` followed by the **meta key**.

Aliases mapped to **functions** must be defined using prefix `func_` followed by the name of the function in the class. Functions based aliases are **READ-ONLY**.

## Meta Data

All the metadata is loaded when a model is retrieved from the database, this information can be accessed with the property `meta`.

```php
/**
 * Use the "meta_key" of choice to access the desired
 * meta value. This property is READ-ONLY, to make meta
 * writable use aliases instead.
 * @var array
 */
$term->meta['meta_key'];
```

### Is READ-ONLY
meta is **READ-ONLY**, to make meta writable use aliases instead.

## Casting

The model can be cast (converted) into multiple data types.

```php
// Casts model to array.
$array = $model->to_array();

// Casts model to json string.
$json = $model->to_json();

// Casts model to json string.
$string = (string)$model;
```

To hide properties (attributes or aliases) from appearing on **JSON** or array formats (when casting) add the `$hidden` property inside your model class.

```php title="app/Models/MyModel.php"
class MyModel extends Model
{
    use FindTrait;

    /**
     * Hidden properties.
     * Removed properties/aliases when model
     * is casted into json, string or array.
     * @var array
     */
    protected $hidden = [
        'term_id',
        'slug',
    ];
}
```

## WP Term

The model can be generated from an object instance of WP_Term.

```php
$model->from_term( $wp_term );
```

Term Models provide elegant handling of WordPress taxonomies and terms — from custom categories/tags to meta-rich taxonomies — all with the same powerful alias, casting, and CRUD features as other models.