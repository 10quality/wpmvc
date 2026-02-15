---
sidebar_position: 4
---

# Option Models

Option Models are a type of [model](/mvc/models.md) that can be created using the framework.

Option Models are single data objects stored in **WordPress**' database, it suits perfectly to save things like configuration properties.

## Model Functionality

Out-of-the-box will provide methods to save, delete and get information to and from **WordPress** database without any complex development needed.

The model's attributes (or data columns) can be accessed as object properties.

## Ayuco Command

### Create command

```bash
php ayuco create optionmodel:{model} {id}
```

* `{model}` -> The name of the class model to be created.
* `{id}` -> The id of the model in the database (optional).

## Usage

Add the use statement at the beginning of your PHP files to specify which model you’ll use in your code.

```php
// Definition to use "AppModel" model (option model).
use MyNamespace\Models\AppModel;

// Usage after definition.
$model = AppModel::find();
```

## Get

Use the `find()` method to retrieve the model loaded with data.

## Save

Saving the information of a model is a piece of cake. Simply call the `save()` method after changing its attributes. This will insert or update the record in the database.

## Aliases

Arguably, the most powerful feature in a model. The `$aliases` property serves as a mapping tool between custom **aliases** and custom fields and/or functions. Defined aliases can be later accessed as regular properties in a loaded model.

## Code Samples

### Definition sample

```php title="app/Models/AppModel.php" showLineNumbers
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\OptionModel as Model;

class AppModel extends Model
{
    use FindTrait;
    
    /**
     * Model ID.
     * @var string
     */
    protected $id = 'my_model';

    /**
     * Aliases.
     * Mapped against custom fields functions.
     * @var array
     */
    protected $aliases = [
        // Alias "config" for custom field "config"
        'config'    => 'field_config',
        // Alias "timer" for custom field "timer"
        'timer'     => 'field_timer',
        // Alias "date" for class function "get_date"
        'date'      => 'func_get_date',
    ];
    
    /**
     * Returns the value used for alias "date".
     * @return string
     */
    public function get_date()
    {
        return $this->timer ? date( 'Y-m-d H:i', $this->timer ) : null;
    }
}
```

### Usage sample

```php
$model = AppModel::find();

/**
 * (1) Echo the value stored on "config" field attribute.
 * (2) Update the value stored on "config" field attribute.
 */
echo $model->config;
$model->config = [1,2,3];

/**
 * (1) Echo the value stored on "timer" field attribute.
 * (2) Update the value stored on "timer" field attribute.
 */
echo $model->timer;
$model->timer = time();

/**
 * (1) Echo the returned value of function "get_date".
 * (2) Aliases based on functions are READ-ONLY
 */
echo $model->date;

// Save updates made on model.
$model->save();
```

## Be aware

Aliases mapped to **field data** must be defined using prefix `field_` followed by a **field key**.

Aliases mapped to **functions** must be defined using prefix `func_` followed by the name of the function in the class. Functions based aliases are **READ-ONLY**.

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

```php title="app/Models/MyModel"
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
        'post_date',
        'cat_ID',
        'name',
        'password',
    ];
}
```

Option Models are ideal for plugin/theme settings, serialized configs, or any single-row data stored via the WordPress options API — simple, powerful, and fully integrated.