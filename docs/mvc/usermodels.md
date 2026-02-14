---
sidebar_position: 6
---

# User Models

User Models are a type of [model](/mvc/models.md) that can be created using the framework.

User Models are related to **WordPress'** users, it suits perfectly for user customizations.

## Model Functionality

Out-of-the-box will provide methods to save, delete and get information to and from **WordPress** database without any complex development needed.

The model's attributes (or data columns) can be accessed as object properties.

## Ayuco Command

### Create command

```bash
php ayuco create usermodel:{model}
```

* `{model}` -> The name of the class model to be created.

## Usage

Add the use statement at the beginning of your PHP files to specify which model you’ll use in your code.

```php
// Definition to use "MyUser" model.
use MyNamespace\Models\MyUser;

// Find record by ID.
$user = MyUser::find( $user_id );

// Create new record
$user = new MyUser;

// Access user properties
echo $user->first_name;
echo $user->user_email;
echo $user->ID;
```

## Get

Use the `find()` method to retrieve an individual record. Pass by a User ID as a parameter.

## Save

Saving the information of a model is a piece of cake. Simply call the `save()` method after changing its attributes. This will insert or update the record in the database.

## Aliases

Arguably, the most powerful feature in a model. The `$aliases` property serves as a mapping tool between custom aliases and meta fields and/or functions. Defined aliases can be later accessed as regular properties in a loaded model.

## Code Samples

### Definition sample

```php title="app/Models/UserModel.php" showLineNumbers
<?php

use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\UserModel as Model;

class UserModel extends Model
{
    use FindTrait;

    /**
     * Aliases.
     * Mapped against category attributes, meta data or functions.
     * @var array
     */
    protected $aliases = [
        // Alias "email" for user attribute "user_email"
        'email'     => 'user_email',
        // Alias "age" for meta data with meta key "age"
        'age'       => 'meta_age',
        // Alias "fullname" for class function "get_fullname"
        'fullname'  => 'func_get_fullname',
    ];

    /**
     * Returns the values used for alias "fullname".
     * @return string
     */
    public function get_fullname()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
```

### Usage sample

```php
$user = MyUser::find(1);

/**
 * (1) Echo the value stored on "first_name" attribute.
 * (2) Update the value stored on "first_name" attribute.
 */
echo $user->first_name;
$user->first_name = 'New name';

/**
 * (1) Echo the meta value stored on meta key "age".
 * (2) Update the meta value stored on meta key "age".
 */
echo $user->age;
$user->age = 28;

/**
 * (1) Echo the returned value of function "get_fullname".
 * (2) Aliases based on functions are READ-ONLY
 */
echo $user->fullname;

// Save updates made on model.
$user->save();
```

**Be aware**

Aliases mapped to **meta data** must be defined using prefix `meta_` followed by the meta key.

Aliases mapped to **functions** must be defined using prefix `func_` followed by the name of the function in the class. Functions based aliases are **READ-ONLY**.

## Meta Data

All the metadata is loaded when a model is retrieved from the database, this information can be accessed with the property meta.

```php
/**
 * Use the "meta_key" of choice to access the desired
 * meta value. This property is READ-ONLY, to make meta
 * writable use aliases instead.
 * @var array
 */
$user->meta['meta_key'];
```

### Is READ-ONLY

`meta` is **READ-ONLY**, to make meta writable use aliases instead.

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

To hide properties (attributes or aliases) from appearing on JSON or array formats (when casting) add the `$hidden` property inside your model class.

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
        'ID',
    ];
}
```

User Models enable elegant, object-oriented handling of WordPress users — from custom profile fields and meta to full CRUD operations — integrated seamlessly with the framework's alias system and casting features.