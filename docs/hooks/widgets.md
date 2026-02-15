---
sidebar_position: 10
---

# Widgets

WordPress [Widgets](https://codex.wordpress.org/WordPress_Widgets) can be registered with [Ayuco](/cli/ayuco.md) or added manually to the [Main Class](/docs/category/hooks).

WPMVC provides a wrapper method `$this->add_widget()` in the `Main` class (extending `Bridge`), allowing you to register widget classes cleanly and keep all registrations centralized.

## Ayuco Command

```bash
php ayuco register widget:{widget}
```

* `{widget}` -> The widget's class name (i.e. `MyWidget`).

Example

```bashp
php ayuco register widget:MyWidget
```

What happens:

* Ayuco creates a new folder called Widgets inside the framework's app folder (`app/Widgets/`).
* It generates the widget class file (e.g., `app/Widgets/MyWidget.php`) with boilerplate extending WP_Widget.
* It automatically registers the widget in `Main.php` using `$this->add_widget('MyWidget')`.

> **Ayuco Is Awesome**
> Ayuco handles namespace loading, class autoloading, and Main Class linkage automatically.

## Add Manually

**Stop And Think**

Register widgets with Ayuco solves many issues, such as loading classes under no namespace and linking the Main Class. **It is highly recommendable to use Ayuco when registering widgets.**

### Manual Registration

You can add widget classes manually by calling `$this->add_widget()` in the `Main` class (typically inside the `init()` method).

```php title="app/Mail.php" showLineNumbers
<?php

namespace MyAwesome\Plugin;

use WPMVC\Bridge;  // or TenQuality\WP\MVC\Bridge depending on version

class Main extends Bridge
{
    public function init()
    {
        // Manual widget added, widget class "MyWidget".
        $this->add_widget( 'MyWidget' );
    }
}
```

* The argument is the fully qualified class name if not in the default namespace, or just the short class name if Ayuco-generated (framework resolves it).
* Widgets must extend the native `WP_Widget` class and implement the required methods (`widget()`, `form()`, `update()`).

#### Ayuco?

When a widget is registered using Ayuco, it is defined in the Main Class same as if it would have been defined manually.

## Best Practices

* Prefer Ayuco for registration to avoid namespace/autoloading issues.
* Place widget classes in `app/Widgets/` for organization (Ayuco does this automatically).
* Use the widget in WP Admin → Appearance → Widgets to test.
* For advanced widgets (with fields, settings), extend the form/update methods.

Widgets integrate seamlessly with WPMVC's MVC flow — register once in Main, render logic in the widget class.