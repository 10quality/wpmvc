---
sidebar_position: 4
---

# Actions

WordPress [Action hooks](https://developer.wordpress.org/apis/hooks/action-reference/) can be added to the **Main Class** using [Ayuco](/cli/ayuco.md) or manually.

WPMVC provides a convenient wrapper method `$this->add_action()` in the `Main` class (which extends `Bridge`), allowing you to link hooks directly to controller methods or views using the `'Controller@method'` syntax.

This approach keeps all hook registrations centralized in `app/Main.php`, promotes MVC separation, and supports the same parameters as WordPress's native `add_action()` (e.g., priority and accepted args).

## Adding Actions with Ayuco

The easiest and recommended way is using Ayuco's `add action` command. It automatically adds the hook to `Main.php`, creates the controller/method if missing, and defaults the controller to `AppController` if none is specified.

### Command Syntax

```bash
php ayuco add action:{action} {handler}
```

* `{action}` — The WordPress action hook name (e.g., `init`, `wp_enqueue_scripts`, `save_post`).
* `{handler}` — The callback in `'Controller@method'` format (or `'view@path.to.view'` for view rendering).

Example

```bash
php ayuco add action:init AppController@init
```

What happens:

* Ayuco adds the hook to the `init()` method in `Main.php`.
* Links it to `AppController::init()`.
* If `AppController` doesn't exist → Ayuco creates it.
* If the `init` method doesn't exist → Ayuco creates it.

> **Ayuco Is Awesome**
> If you omit the handler, Ayuco defaults to `AppController`.
> If the controller or method is missing, Ayuco generates them automatically.

## Adding Actions Manually

You can register actions directly in the `Main` class (typically inside the `init()`` or `on_admin()` methods).

Syntax

```php
$this->add_action( string $hook, string $handler, int $priority = 10, int $accepted_args = 1 );
```

* `$hook` — The action name (same as WP).
* `$handler` — `'Controller@method'` or `'view@dot.path.to.view'`.
* `$priority` — Execution order (default 10).
* `$accepted_args` — Number of arguments the callback expects (default 1).

## Example in Main.php

```php title="app/Main.php" showLineNumbers
<?php

namespace MyAwesomePlugin;

use WPMVC\Bridge;

class Main extends Bridge
{
    public function init()
    {
        // Basic action linked to a controller method
        $this->add_action( 'init', 'CustomController@app_init' );

        // Action for wp_head
        $this->add_action( 'wp_head', 'CustomController@header' );

        // Action with custom priority (executes later)
        $this->add_action( 'init', 'CustomController@app_init', 20 );
    }
}
```

* Ayuco-generated hooks appear exactly like manual ones in `Main.php`.
* Use this method when you need fine control over priority or args, or for one-off additions.

## Passing Parameters to Handlers

To pass specific arguments from the WP hook to your callback (e.g., mapping hook params to method args), use the third parameter as an array of param names:

```php
$this->add_action( 'woocommerce_thankyou', 'view@woocommerce.thankyou', ['order_id'] );
```

This passes the `$order_id` from the `woocommerce_thankyou` hook to your view or controller.

For full WP compatibility, the method supports `$priority` and `$accepted_args` just like native `add_action()``.

## Related Resources

* [WordPress Action Hooks Reference](https://developer.wordpress.org/apis/hooks/action-reference/) (official WP docs)
* [Main Class](/docs/category/hooks) — More on the bootstrap/hooks router
* [Ayuco](/cli/ayuco.md) — Full CLI commands

Use actions to hook into WordPress lifecycle events while keeping your logic in controllers — the artisan way.