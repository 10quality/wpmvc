---
sidebar_position: 7
---

# Shortcodes

WordPress Shortcodes can be added to the **Main Class** with [Ayuco](/cli/ayuco.md) or manually.

WPMVC provides a wrapper method `$this->add_shortcode()` in the `Main` class (extending `Bridge`), allowing you to register shortcodes cleanly and link them directly to controller methods or views using the `'Controller@method'` or `'view@dot.path.to.view'` syntax.

This keeps all shortcode registrations centralized in `app/Main.php`, promoting MVC separation.

## Ayuco Command

```bash
php ayuco add shortcode:{shortcode} {handler}
```

* `{shortcode}` -> The shortcode's string key (i.e. `hello_world`). This will be used to identify the shortcode in the content (i.e. `[hello_world]`).
* `{handler}` -> A controller or view to handle the shortcode.

Example

```bash
php ayuco add shortcode:hello_world view@shortcodes.hello-world
```

In the command above, Ayuco will add WordPress shortcode **“[hello-world]”** to the project and will establish view “shortcodes.hello-world” as the handler.

> Ayuco Is Awesome
> If no handler is defined, Ayuco will default it to “AppController”.
> If the defined controller in the command doesn’t exist then Ayuco will create it.
> If the defined controller’s method in the command doesn’t exist then Ayuco will create it.
> If the defined view in the command doesn’t exist then Ayuco will create it.

## Add Manually

Shortcodes can be added manually by defining them in the Main Class (typically inside the `init()`` method).

Syntax

```php
$this->add_shortcode( string $tag, string $handler );
```

* `$tag` — The shortcode name (without brackets, e.g., `'hello_world'`` for `[hello_world]`).
* `$handler` — `'Controller@method'` or `'view@dot.path.to.view'`.

## Example in Main.php

```php title="app/Main.php" showLineNumbers
<?php

namespace MyAwesomePlugin;

use WPMVC\Bridge;

class Main extends Bridge
{
    public function init()
    {
        // Shortcode "[hello_world]" added. View as handler.
        $this->add_shortcode( 'hello_world', 'view@shortcodes.hello-world' );

        // Shortcode "[my_sc]" added. Controller as handler.
        $this->add_shortcode( 'my_sc', 'ShortcodeController@sc' );
    }
}
```

In the sample above, multiple shortcodes have been added to the Main Class. Notice how handlers are defined.

When a shortcode is added using Ayuco, it is defined in the Main Class same as if it would have been defined manually.

**Ayuco?**
When a shortcode is added using Ayuco, it is defined in the Main Class same as if it would have been defined manually.

## Related Resources

* [WordPress Shortcode API](https://codex.wordpress.org/Shortcode_API) (official WP docs)
* [Main Class](/docs/category/hooks) — More on the bootstrap/hooks router
* [Ayuco](/cli/ayuco.md) — Full CLI commands
* [Views](/mvc/views.md) — For handling shortcode output via views

Use shortcodes to embed dynamic content (e.g., forms, galleries, custom blocks) into posts/pages while keeping logic in controllers or views — the artisan way.