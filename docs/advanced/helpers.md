---
sidebar_position: 20
---

# Helpers

This page documents the global helper functions included with the **WordPress MVC** (WPMVC) core. These functions can be used anywhere in a WordPress project (themes, plugins, etc.) without manually importing classes.

## get_bridge

Return a framework bridge instance for a given namespace.

```php
$main = get_bridge( 'MyNamespace' );
```

**Parameter:**

* `string` `$namespace` — The project namespace you want a bridge for.

**Returns:** instance or `null` if not found.

This is useful when you need to resolve an instance bound to a specific namespace context in the framework.

## resize_image

Resize an image and return the resulting URL.

```php
$url = resize_image( $path_or_url, $width, $height, $crop, $id );
```

**Parameters:**

* `string` `$path_or_url` — The image path or URL to resize.
* `int` `$width` — Width in pixels.
* `int` `$height` — Height in pixels.
* `bool` `$crop` (optional) — Whether to crop the image. Defaults to true.
* `mixed` `$id` (optional) — A unique identifier (e.g., a post ID) to avoid filename conflicts.

**Returns:** `string` — The URL to the resized image.

This function uses WordPress's built-in image editor and stores the new file in the uploads directory.

## assets_url

Generate the public URL to an asset in themes or plugins.

```php
$url = assets_url( 'img/logo.png', __FILE__ );
```

**Parameters:**

* `string` `$relative_path` — Relative path inside the assets/ folder.
* `string` `$file` — The current file path (typically __FILE__).
* `string|null` `$scheme` (optional) — Forces the URL scheme (http or https).
* `bool` `$is_network` (optional) — If in a multisite network, use the network base URL.

**Returns:** `string` — Fully qualified URL to the asset.

This handles Polylang and WPML compatibility and cleans up the base path before returning the URL.

### assets_path

Generate the filesystem path to an asset in themes or plugins.

```php
$path = assets_path( 'css/app.css', __FILE__ );
```

**Parameters:**

* `string` `$relative` — Relative asset path.
* `string` `$file` — The caller file path.

**Returns:** `string` — Absolute path on disk to the asset.

This matches the logic in `assets_url()`` but returns a filesystem path instead of a URL.

### get_ayuco

Return a configured Ayuco CLI instance for project scaffolding.

```php
$ayuco = get_ayuco( $project_path );
```

**Parameter:**

* `string` `$path` — Your project base path.

**Returns:** `object` — Ayuco listener with commands registered.

The returned Ayuco instance has commands like Add, Create, Generate, Register, Set, Setup, and Prettify pre-registered.

## get_wp_home_path

Get the absolute WordPress home directory path.

```php
$home_path = get_wp_home_path();
```

**Returns:** `string` — The root path of the WordPress installation.

This wraps WordPress's `get_home_path` (loading it if necessary) or falls back to a best-effort regex search.

## exists_bridge

Determine whether a bridge exists for a given namespace.

```php
if ( exists_bridge( 'MyNamespace' ) ) {
    // Do something
}
```

**Parameter:**

* `string` `$namespace` — Namespace to check.

**Returns:** `bool` — Whether a bridge exists.

## theme_view

Render a theme view directly.

```php
theme_view( 'partials.header', [ 'title' => 'Welcome' ] );
```

**Parameters:**

* `string` `$key` — The view key (path).
* `array` `$params` (optional) — Parameters available in the view.

**Output:** Prints the rendered view if the theme bridge is available.

## Summary

These helpers provide lightweight procedural access to:

* Asset URLs and filesystem paths
* Image resizing
* CLI scaffolding (Ayuco)
* Application bridge resolution
* Theme view rendering

They are globally available anywhere in your WordPress installation once WP-MVC is loaded.