WORDPRESS PLUGIN CORE (For [Wordpress Plugin](https://github.com/amostajo/wordpress-plugin))
--------------------------------

[![Latest Stable Version](https://poser.pugx.org/amostajo/wordpress-plugin-core/v/stable)](https://packagist.org/packages/amostajo/wordpress-plugin-core)
[![Total Downloads](https://poser.pugx.org/amostajo/wordpress-plugin-core/downloads)](https://packagist.org/packages/amostajo/wordpress-plugin-core)
[![License](https://poser.pugx.org/amostajo/wordpress-plugin-core/license)](https://packagist.org/packages/amostajo/wordpress-plugin-core)

Core library for [Wordpress Plugin](https://github.com/amostajo/wordpress-plugin) (A Wordpress template that comes with composer and MVC);

## Installation

Add

```json
"amostajo/wordpress-plugin-core": "1.0.*"
```

to your composer.json. Then run `composer install` or `composer update`.

## Add-on development

WP Core now supports Add-on development. To create your custom package, simply create an Add-on main class that extends from this package abstract, like the following example:

```php
namespace MyNamespace;

use Amostajo\WPPluginCore\Classes\Addon;

class PostPicker extends Addon
{
    /**
     * Function called when plugin or theme starts.
     * Add wordpress hooks (actions, filters) here.
     */
    public function init()
    {
        // YOUR CUSTOM CODE HERE.
    }

    /**
     * Function called when user is on admin dashboard.
     * Add wordpress hooks (actions, filters) here.
     */
    public function on_admin()
    {
        // YOUR CUSTOM CODE HERE.
    }
}
```

This is how you should add your Wordpress hooks:

```php
namespace MyNamespace;

use Amostajo\WPPluginCore\Classes\Addon;

class PostPicker extends Addon
{
    /**
     * Function called when plugin or theme starts.
     * Add wordpress hooks (actions, filters) here.
     */
    public function init()
    {
        add_filter( 'post_content', [ &$this, 'picker_filter' ] )
    }

    /**
     * Called by wordpress.
     */
    public function picker_filter()
    {
        // YOUR CUSTOM CODE HERE.
    }
}
```

### Accessing the plugin Main class

You can call the main class from any custom method in your `Add-on` class, like this:

```php
/**
 * Custom method.
 */
public function picker_filter()
{
    // Getting a config settings.
    $this->main->config->get( 'setting' );
}
```

Calling for Add-on's controllers or views:


### MVC

```php
/**
 * Custom method.
 */
public function picker_filter()
{
    // Calling MVC.
    $this->mvc->call( 'Controller@method' );
}
```

Your controllers should be placed in a `controllers` folder on the same level as your `Add-on` class, same for the `views` folder.

### Calling ADD-ON methods from main class

The `Main` class can call methods in the Add-on by adding the `addon_` prefic, like for example `addon_picker_filter`.

### Setup plugin or theme

Finally add your package in the configuration file. For example:

```php
    'addons' => [
        'MyNamespace\PostPicker',
    ],
```

## Coding Guidelines

The coding is a mix between PSR-2 and Wordpress PHP guidelines.

## License

**Lightweight MVC** is free software distributed under the terms of the MIT license.
