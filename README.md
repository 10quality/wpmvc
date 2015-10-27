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

## Addon development

WP Core now supports Addon development. To create your custom package, simply create an Addon main class that extends from this package abstract, like the following example:

```php
use Amostajo\WPPluginCore\Abstracts\Addon;

class PostPicker extends Addon
{
    /**
     * Function called when plugin or theme starts.
     * Add wordpress hooks (actions, filters) here.
     * @param object &$main Main class plugin (required!).
     */
    public function init( &$main )
    {
        // YOUR CUSTOM CODE HERE.
    }

    /**
     * Function called when user is on admin dashboard.
     * Add wordpress hooks (actions, filters) here.
     * @param object &$main Main class plugin (required!).
     */
    public function on_admin( &$main )
    {
        // YOUR CUSTOM CODE HERE.
    }
}
```

This is how you should add your Wordpress hooks:

```php
use Amostajo\WPPluginCore\Abstracts\Addon;

class PostPicker extends Addon
{
    /**
     * Function called when plugin or theme starts.
     * Add wordpress hooks (actions, filters) here.
     */
    public function init( &$main )
    {
        add_filter( 'post_content', [ &$main, 'addon_picker_filter' ] )
    }

    /**
     * Function called by Plugin / Theme main class.
     * This is the function declared on the INIT function "addon_picker_filter"
     */
    public function picker_filter()
    {
        // YOUR CUSTOM CODE HERE.
    }
}
```

In the example above, the `Main` class will look for the method called `picker_filter` because it has the prefix `addon_picker`.

You can call the main class from any custom method in your `Addon` class, like this:

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

Calling for Addon's controllers or views:

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

Your controllers should be placed in a `controllers` folder on the same level as your `Addon` class, same for the `views` folder.

## Coding Guidelines

The coding is a mix between PSR-2 and Wordpress PHP guidelines.

## License

**Lightweight MVC** is free software distributed under the terms of the MIT license.
