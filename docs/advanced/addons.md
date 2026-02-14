---
sidebar_position: 25
---

# Add-Ons

**WordPress MVC** (WPMVC) supports **Add-Ons** — external packages that extend your project with new functionality. Add-Ons act as modular extensions built specifically for the framework.

## What Are Add-Ons?

Add-Ons are self-contained packages that enhance or customize your application’s behavior. They can:

* Add WordPress hooks (actions and filters)
* Register additional controllers, views, or resources
* Encapsulate reusable functionality for other projects

Add-Ons integrate seamlessly into WPMVC by being registered in your application configuration and then automatically booted by the framework.

## Registering Add-Ons

To enable an Add-On, add its main class namespace to the `addons` section of your configuration file.

Example:

```php title="app/Config/app.php"
return [

    // OTHER SETTINGS...

    'addons' => [
        'AddOnNamespace\Addon',
    ],

];
```

This tells WPMVC to load and initialize your add-on when the application starts.

## Creating an Add-On

### Step 1 - Add-On Template (Starter Boilerplate)

To help you get started building Add-Ons, there’s an official addon development template:

* [10quality/wpmvc-addon‑template on GitHub](https://github.com/10quality/wpmvc-addon-template) (Add‑On Template)

This repository provides a starter boilerplate for addon development. It includes:

* A structured directory for your addon code.
* A sample `composer.json` file configured for PSR-4 autoloading.
* The basic Add-On class setup ready to customize.
* Example assets and view templates.

#### How to Use the Template

1. Clone or fork the repository:
```bash
git clone https://github.com/10quality/wpmvc-addon-template.git
```
2. Update the namespace in `composer.json` and `addon/Addon.php` to match your addon:
```json title="composer.json"
{
  "autoload": {
    "psr-4": {
      "Your\\Addon\\Namespace\\": "addon/"
    }
  }
}
```
2. Rename and customize the Addon class inside addon/Addon.php.
3. Adjust assets and view files as needed for your addon’s features.

Using this template gives you a compliant structure that integrates with WPMVC's addon system out of the box.

### Step 2 — Modify the Main Class

Your Add-On should define a main class that extends the base Addon class.

```php title="addon/MyAddon.php"
namespace MyNamespace;

use WPMVC\Addon;

class MyAddon extends Addon
{
    /**
     * Called when the add-on is initialized.
     */
    public function init()
    {
        // YOUR CUSTOM CODE HERE.
    }

    /**
     * Called when on the WordPress admin dashboard.
     */
    public function on_admin()
    {
        // YOUR ADMIN LOGIC HERE.
    }
}
```

Add-Ons typically hook into WordPress actions and filters within these methods to extend behavior.

### Step 3 - Registering WordPress Hooks

Inside your Add-On methods, add WordPress hooks just like you would in a plugin:

```php title="addon/MyAddon.php"
class MyAddon extends Addon
{
    public function init()
    {
        add_filter( 'body_class', [ &$this, 'addBodyClass' ] );
        add_action( 'wp_enqueue_scripts', [ &$this, 'enqueueAssets' ] );
    }

    public function addBodyClass( $classes )
    {
        $classes[] = 'my-custom-class';
        return $classes;
    }

    public function enqueueAssets()
    {
        wp_enqueue_script(
            'my-addon',
            assets_url( '../vendor/my-addon/assets/js/addon.js', __FILE__ ),
            [ 'jquery' ]
        );
    }
}
```

This lets your Add-On attach logic to WordPress events in a portable, reusable package.

## Add-On Package Requirements

To ensure your Add-On is properly maintained and discoverable:

### Composer Registration

Add-Ons must be registered as Composer packages (e.g., on Packagist.org). This allows them to be installed via Composer and resolved by autoloading.

## Accessing Main Application Inside an Add-On

Your Add-On can access the framework’s core and configuration by referencing the main application instance:

```php title="addon/MyAddon.php"
class MyAddon extends Addon
{
    public function someMethod()
    {
        // Get config via the main app
        $config = $this->main->config->get( 'some.setting' );
    }
}
```

## Integrating With MVC

Add-Ons can also interact with the MVC layer provided by WP-MVC. For example:

```php title="addon/MyAddon.php"
class MyAddon extends Addon
{
    public function controllerExample()
    {
        // Call a controller action
        $this->mvc->call( 'Controller@method' );

        // Render a view from the Add-On
        echo $this->mvc->view->get( 'view.key' );
    }
}
```

* Controllers should be located inside your Add-On at:
`<addon_root>/controllers/`
* Views should be located under:
`<addon_root>/views/`

This lets Add-Ons participate in MVC workflows while keeping their logic modular and independent from the core project.

Summary

Add-Ons are extensible packages created for the WPMVC framework to:

* Encapsulate reusable features
* Add WordPress hooks and application logic
* Extend MVC controllers and views

They are registered via configuration, structured as Composer packages, and integrate seamlessly with the framework’s lifecycle.