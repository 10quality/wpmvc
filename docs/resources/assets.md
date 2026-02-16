---
sidebar_position: 1
---

# Assets

Any front-end file, **non-PHP**, is considered an asset in the framework; JavaScript, CSS, SASS, SCSS, LESS, fonts, images and views (templates) are examples of asset files.

## Gulp

Gulp is included out-of-the-box in the framework to handle compilation of styles and scripts, and deployments. To install Gulp dependencies, run:

```bash
npm install
```

NodeJS is required prior to using Gulp.

## Raw vs Compiled

Optimization and development are key factors empowered by the framework. Predefined Gulp tasks compile, minify, and concatenate raw assets for efficiency.

All CSS/JS/SASS files under `[project]/assets/raw` are subjected to compilation and/or concatenation. Files should be stored in the following subfolders:

* `[...]/assets/raw/css`: CSS files are concatenated into `app.css` and stored in `[..]/assets/css`. Subfolders (e.g., `admin`) generate corresponding files like `admin.css`.
* `[...]/assets/raw/js`: JS files are concatenated into `app.js` and stored in `[..]/assets/js`. Subfolders (e.g., `admin`) generate `admin.js`.
* `[...]/assets/raw/sass`: SASS/SCSS files are compiled into CSS and stored in `[..]/assets/css`.

To compile assets from the raw folder:

```bash
gulp dev
```

Or alias:
```bash
npm run dev
```

## Watch

The framework provides watch tasks to auto-compile raw files on changes:

* `gulp watch`: Watch any change in the raw folder.
* `gulp watch-styles`: Watch only style changes (CSS/SASS/SCSS).
* `gulp watch-sass`: Watch only SASS/SCSS changes.
* `gulp watch-js`: Watch only JS changes.

Or alias:
```bash
npm run watch
```

## Auto-enqueue

By default, compiled files `app.css` and `app.js` are auto-enqueued into WordPress. Auto-enqueue settings are configurable in the configuration file:

```php title="app/Config/app.php"
return [
    'autoenqueue' => [
        'enabled' => true,
        'assets' => [
            [
                'asset'  => 'css/app.css',
                'dep'    => [],
                'footer' => false,
            ],
            [
                'asset'  => 'js/app.js',
                'dep'    => [],
                'footer' => true,
            ],
        ],
    ],
];
```

* `'enabled'`: Enables or disables auto-enqueue.
* `'assets'`: Array of assets to auto-enqueue, each with:
  * `'asset'`: Path to the asset (e.g., `css/app.css`).
  * `'dep'`: Array of dependencies (e.g., `['jquery']`).
  * `'footer'`: Boolean; `true` loads in footer, `false` in header.
  * Optional: `'id'`, `'version'`, `'enqueue'` (if `false`, registers but does not enqueue), `'is_admin'` (for admin dashboard).

Example: Register without auto-enqueuing:

```php
    'enqueue' => false
```

Example: Enqueue admin asset:

```php
    'is_admin' => true
```

Example: Custom asset with dependencies:

```php
[
    'asset'  => 'js/custom.js',
    'dep'    => ['jquery'],
    'footer' => true,
]
```

Asset identifier in WordPress: lowercase filename (without `.min`), dash, and lowercase namespace (e.g., `bootstrap-mynamespace`). Used for dependency management.

Example with explicit ID and version:

```php
[
    'asset'   => 'js/bootstrap.min.js',
    'id'      => 'bootstrap',
    'dep'     => ['jquery'],
    'version' => '4.3.0',
    'footer'  => true,
]
```

### Deployment
To compile assets for production, minify, remove development files, and prepare a ZIP:

```bash
gulp build
```

Or alias:
```bash
npm run build
```

For deployment without ZIP (e.g., for CI/CD), output to `[project]/builds/deploy`:

```bash
gulp deploy
```

Or alias:
```bash
npm run deploy
```

Deployment result: Assets in `/assets/js` and `/assets/css` are minified; unnecessary files and development vendor packages are excluded.

## Usage

Use `assets_url()` or `assets_path()` to get the URL or path of an asset:

```html
<img src="<?php echo assets_url('img/my-logo.png', __FILE__); ?>" />
```

```php
$path = assets_path('img/my-logo.png', __FILE__);
```

## Webpack

If `webpack.config.js` exists at the project root, WPMVC adds a webpack task and integrates it into the build process.

Add to `package.json`:

```json title="package.json"
{
  "scripts": {
    "webpack": "webpack --hide-modules"
  }
}
```

Install Webpack via npm:

```bash
npm install webpack --save
```

Webpack is not included as a dependency by default.

Assets in WPMVC are optimized for development and production, with seamless auto-enqueuing via configuration — ensuring clean, performant loading in WordPress without manual hook clutter in the Main class.