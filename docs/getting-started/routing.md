---
sidebar_position: 3
---

# Hooks & Routing

> The Role of app/Main.php

In WordPress MVC (WPMVC), the **`app/Main.php`** file serves as the central **bootstrap** and **hooks router**. It is the main class that connects WordPress with the framework's MVC structure, allowing you to register all actions, filters, shortcodes, and other hooks in one organized place.

By extending the framework's `Bridge` class, `Main` provides wrapper methods like `$this->add_action()` and `$this->add_filter()` that support direct linking to controller methods using the `'Controller@method'` syntax. This keeps your code clean, MVC-compliant, and easy to maintain — no scattered `add_action()` calls across files.

## Why app/Main.php?

WordPress is built around its hook system, but in traditional development, hooks often lead to disorganized code. WPMVC centralizes them in `app/Main.php` to:
- Enable MVC routing: Hooks can call controller methods or render views directly.
- Support parameter passing and dynamic callbacks.
- Integrate seamlessly with WordPress while promoting separation of concerns.

Ayuco generates this file during setup, and you can modify it to register all your project's hooks.

## Structure of app/Main.php

Here's a typical `app/Main.php` after Ayuco setup:

```php title="app/Main.php" showLineNumbers
<?php
/**
 * Main entry point and hooks router.
 *
 * @package MyAwesome\Plugin
 */

namespace MyAwesome\Plugin;

use WPMVC\Bridge;

class Main extends Bridge
{
    /**
     * Called automatically on plugin load (e.g., via 'plugins_loaded').
     * Registers core hooks here or in dedicated methods like init() or on_admin().
     */
    public function init()
    {
        // Register a filter hook linked to a controller method
        $this->add_filter( 'the_content', 'PostController@the_content' );

        // Register an action hook to a controller method
        $this->add_action( 'save_post', 'PostController@save' );

        // Shortcode linked to a view
        $this->add_shortcode( 'hello-world', 'view@shortcodes.hello-world' );

        // Action with parameter mapping (passes 'product_id' to the view)
        $this->add_action( 'woocommerce_thankyou', 'view@woocommerce.thankyou', ['product_id'] );

        // Passing the Main instance as a parameter to a controller method
        $this->add_action( 'init', 'AppController@init', [$this] );

        // Other registrations
        $this->add_widget( 'MyCustomWidget' );
        $this->add_model( 'MyModel' );
        $this->add_asset( 'css/public.css' );
    }

    /**
     * Admin-specific hooks (called on 'admin_init' or similar).
     */
    public function on_admin()
    {
        // Admin-only hooks
        $this->add_action( 'admin_menu', 'AdminController@add_menu' );
    }
}
```

Key elements:

* Extends Bridge: Provides the `$this->add_*()`` methods.
* `init()` Method: Often hooked to WordPress's 'init' action internally by the framework. Use it for global registrations.
* `on_admin()` Method: For admin-area hooks (auto-called in admin context).
* Callback Syntax:
  * Controllers: `'ControllerClass@method'`` — Resolves to the method in the specified controller.
  * Views: `'view@view.key'` — Renders the view file (e.g., `assets/views/view/key.php`).
  * Optional third argument: Array of parameters to pass (e.g., `['param1', 'param2']` maps WP hook args to callback).
* The framework handles resolving the string to the actual callable (e.g., [new ControllerClass, 'method']).

## How Routing Works

WPMVC's "routing" is hook-driven rather than URL-based (no full router like in Laravel). Hooks act as entry points:

* A WP hook fires → Calls the registered controller method or view.
* Controllers handle logic, fetch models, and render views.

## Available Hook Methods

From the framework:

* `$this->add_action('hook', 'callback', [$params], $priority, $accepted_args)`
* `$this->add_filter('hook', 'callback', [$params], $priority, $accepted_args)`
* `$this->add_shortcode('tag', 'callback', [$params])`
* `$this->add_widget('WidgetClass')`
* `$this->add_model('ModelClass')`
* `$this->add_asset('path/to/asset')`

These wrappers ensure MVC compatibility and auto-resolve callbacks.

## Accessing the Main Instance

Globally retrieve the Main instance, on a plugin:

```php
$main = get_bridge( 'MyAwesomePlugin' );  // Or 'theme' for themes
$main->add_action( ... );  // Dynamic additions if needed
```

Or on a theme:
```php
$main = get_bridge( 'theme' );
```

## Removing Hooks

Use the framework's remove methods:

```php
$this->remove_action( 'init', 'ConfigController@init' );
$this->remove_filter( 'the_content', 'PostController@the_content' );
```

Or globally:

```php
get_bridge( 'MyAwesomePlugin' )->remove_action( 'hook', 'callback' );
```

## Best Practices

* Organize by context: Use `init()` for frontend/global, `on_admin()` for backend.
* Delegate complex logic: Keep `Main` focused on registration; put business logic in controllers.
* Use Ayuco: Commands like `php ayuco add action:init ConfigController@init` auto-add to Main.php.
* Flush rewrites: On activation (use register_activation_hook() in your main plugin file).
* Debug: Check if hooks fire with error_log() or tools like Query Monitor.

`app/Main.php` is your project's command center — use it to route WordPress hooks elegantly into your MVC flow.