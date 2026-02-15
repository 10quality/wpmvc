---
sidebar_position: 10
---

# Configuration

After running the Ayuco setup wizard (`php ayuco setup`), WordPress MVC (WPMVC) generates a clean, extensible configuration system in the `app/Config/` folder. This lets you control core behavior, add custom settings, override for environments, and integrate add-ons — all without touching WordPress core files.

The framework uses plain PHP files that **return arrays**, making configuration simple, type-safe, and IDE-friendly.

## Main Configuration File: app/Config/app.php

This is the primary config file. Ayuco populates it with defaults during setup, including your namespace, version, text domain, and more.

Typical structure after setup:

```php title="app/Config/app/php" showLineNumbers
<?php

return [
    // Project metadata (often set by Ayuco)
    'namespace'     => 'MyAwesomePlugin',           // Your PHP namespace
    'version'       => '1.0.0',
    'text_domain'   => 'my-awesome-plugin',
    'author'        => 'Your Name <you@example.com>',
    'license'       => 'MIT',

    // Core framework settings
    'cache'         => [
        'enabled'   => true,
        'engine'    => 'files',  // or 'phpfastcache', etc.
        // Other cache options...
    ],

    // Add-ons registration (array of fully-qualified class names)
    'addons'        => [
        // Example: \WPMVC\Addons\Status\StatusAddon::class,
        // Add your installed add-ons here
    ],

    // Custom app settings (add your own!)
    'my_custom'     => [
        'api_key'       => 'your-secret-key',
        'debug_mode'    => false,
        'items_per_page'=> 20,
    ],

    // Other optional sections (framework may add these)
    'assets'        => [
        // Asset registration if not using auto-enqueue
    ],
    'hooks'         => [
        // Global hook overrides if needed
    ],
];
```

> Tip: Never commit sensitive values (API keys, secrets) to git. Use environment overrides (see below).

### Accessing Configuration

Use the bridge helper (generated during setup) to read values anywhere in your code:

```php
// Get a top-level value
$version = get_bridge( 'MyAwesomePlugin' )->config->get( 'version' );

// Nested value with dot notation
$api_key = get_bridge( 'MyAwesomePlugin' )->config->get( 'my_custom.api_key' );

// Default fallback
$per_page = get_bridge( 'MyAwesomePlugin' )->config->get( 'my_custom.items_per_page', 10 );
```

This returns null if the key doesn't exist (or your fallback).

## Adding Custom Configuration Files

Create additional files in `app/Config/` for better organization (e.g., `api.php`, `database.php`).

Example:
```php title="app/Config/api.php" showLineNumbers
<?php

return [
    'production' => [
        'endpoint' => 'https://api.example.com/v1',
        'key'      => 'prod-key-123',
    ],
    'staging' => [
        'endpoint' => 'https://staging.example.com/v1',
        'key'      => 'staging-key-abc',
    ],
];
```

Load and access it:
```php
$api_config = get_bridge( 'MyAwesomePlugin' )->load_config( 'api' );
$endpoint = $api_config->get( 'production.endpoint' );
```

## Environment-Specific Overrides

Override any config value without editing files — ideal for dev/staging/prod.

In your WordPress `wp-config.php` (or `.env` if using a plugin like wp-env or dotenv):

```php
// Override a single value
define('my_custom.api_key', 'dev-local-key-xyz');

// Override nested values (dot notation in define name)
define('my_custom.debug_mode', true);

// Override core settings
define('cache.enabled', false);
define('version', '1.1.0-beta');
```

The framework prioritizes `define()` values over `app.php`.

> Pro tip: For full `.env` support, consider a lightweight plugin like `vlucas/phpdotenv` (Composer-require it and bootstrap in your main plugin file).


## Registering Add-ons

Many WPMVC add-ons (Status, Administrator, Customizer, etc.) require registration here.

Example for the Status add-on:

```php
'addons' => [
    \WPMVC\Addons\Status\StatusAddon::class,
    // \Your\Other\Addon::class,
],
```

After adding, the add-on activates automatically on the next load. Check add-on docs for any extra config keys.

## Best Practices

* Use Ayuco for initial setup — It handles namespace, metadata, and boilerplate reliably (`php ayuco set version:2.0.0`, `php ayuco set namespace:NewNamespace`, etc.).
* Keep configs lean — Put one-off or rarely changed values in `app.php`; group related settings in custom files.
* Secure secrets — Never hardcode keys; use defines, `.env`, or WordPress options for production.
* Cache awareness — If disabling cache ('cache' => ['enabled' => false]), run `php ayuco cache:clear` after changes.
* Version control — Commit the config structure (with placeholder values), ignore sensitive overrides.

Your configuration is now set up for clean, maintainable, and scalable development — the artisan way.