---
sidebar_position: 5
---

# Filters

WordPress [Filter hooks](https://codex.wordpress.org/Plugin_API/Filter_Reference) can be added to the **Main Class** with [Ayuco](/cli/ayuco.md) or manually.

WPMVC provides a convenient wrapper method `$this->add_filter()` in the `Main` class (which extends `Bridge`), allowing you to link filters directly to controller methods or views using the `'Controller@method'` syntax.

This keeps all hook registrations centralized in `app/Main.php`, promotes MVC separation, and supports the same parameters as WordPress's native `add_filter()` (e.g., priority and accepted args).

## Adding Filters with Ayuco

The easiest and recommended way is using Ayuco's `add filter` command. It automatically adds the hook to `Main.php`, creates the controller/method if missing, and defaults the controller to `AppController` if none is specified.

### Command Syntax

```bash
php ayuco add filter:{filter} {handler}
```

* `{filter}` — A WordPress filter hook name (e.g., `body_class`, `the_content`, `excerpt_length`).
* `{handler}` — The callback in `'Controller@method'` format (or `'view@path.to.view'` for view rendering).

Example

```bash
php ayuco add filter:body_class AppController@body_class
```

What happens:

* Ayuco adds the filter hook "body_class" to the project.
* It establishes `AppController::body_class()` as the handler.
* If `AppController` doesn't exist → Ayuco creates it.
* If the `body_class` method doesn't exist → Ayuco creates it.

> **Ayuco Is Awesome**
> If no handler is defined, Ayuco will default it to "AppController".
> If the defined controller in the command doesn't exist then Ayuco will create it.
> If the defined controller's method in the command doesn't exist then Ayuco will create it.

## Adding Filters Manually

You can register filters directly in the `Main` class (typically inside the `init()` or `on_admin()` methods).

Syntax

```php
$this->add_filter( string $hook, string $handler, int $priority = 10, int $accepted_args = 1 );
```

* `$hook` — The filter name (same as WP).
* `$handler` — `'Controller@method'` or `'view@dot.path.to.view'`.
* `$priority` — Execution order (default 10; lower numbers run earlier).
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
        // Manual hook added for hook "body_class".
        $this->add_filter( 'body_class', 'CustomController@body' );
        
        // Manual hook added for hook "the_content".
        $this->add_filter( 'the_content', 'CustomController@content' );

        // Hook with custom priority (executes later)
        $this->add_filter( 'body_class', 'CustomController@body', 20 );
    }
}
```

In the sample above, multiple manual filter hooks have been added to the `Main` Class. Notice how handlers are defined.

When a filter is added using Ayuco, the hook is defined in the Main Class same as if it would have been defined manually.

## Passing Parameters to Handlers

The method supports `$priority` and `$accepted_args` just like native `add_filter()`. For passing specific arguments from the WP filter (e.g., mapping hook params), use the same pattern as actions.

## Related Resources

* [WordPress Filter Hooks Reference](https://developer.wordpress.org/apis/hooks/filter-reference/) (official WP docs)
* [Main Class](/docs/category/hooks) — More on the bootstrap/hooks router
* [Ayuco](/cli/ayuco.md) — Full CLI commands

Use filters to modify data flowing through WordPress (e.g., content, classes, titles) while keeping your logic clean in controllers — the artisan way.