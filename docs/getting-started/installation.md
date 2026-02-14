---
sidebar_position: 1
---

# Installation

WordPress MVC (WPMVC) is installed via **Composer** (for PHP dependencies) and **npm** (for frontend assets/build tools). The framework includes **Ayuco**, a powerful CLI for setup, scaffolding, and commands.

This guide walks you through installing WPMVC as the foundation for a custom plugin or theme. (For add-ons like metaboxer or license-key, see the Add-ons section after core setup.)

## Requirements

- **PHP** ≥ 7.4 (recommended: 8.0+ for best compatibility)
- **WordPress** ≥ 5.8 (latest stable recommended)
- **Composer** (global or local)
- **Node.js** ≥ 14 and **npm** ≥ 7 (for asset compilation with Gulp)
- WordPress site with write access to the `wp-content/plugins/` or `wp-content/themes/` folder

## Step 1: Create a New Project Folder

Choose whether you're building a **plugin** or **theme**.

- For a **plugin** (recommended for most custom functionality):
```bash
cd wp-content/plugins/
mkdir my-awesome-plugin
cd my-awesome-plugin
```

- For a **theme** (if building a custom theme):
```bash
cd wp-content/themes/
mkdir my-awesome-theme
cd my-awesome-theme
```

## Step 2: Install WPMVC via Composer

The main repo (10quality/wpmvc) bundles the core, Ayuco, commands, and starter structure.

Run:
```bash
composer create-project --no-plugins 10quality/wpmvc .
```

Or, if starting from an empty folder:

```bash
composer require 10quality/wpmvc --no-plugins
```

> Note: The `--no-plugins` flag prevents Composer from running post-install scripts automatically (common in WordPress environments to avoid conflicts).

This pulls in:

* `10quality/wpmvc-core` (MVC logic, caching, logging)
* `10quality/ayuco` (CLI tool)
* `10quality/wpmvc-commands` (scaffolding helpers)
* Gulp setup for assets

## Step 3: Install Frontend Dependencies (npm)

WPMVC uses Gulp for compiling Sass/JS and managing assets.

```bash
npm install
```

This installs Gulp, Sass, Babel, etc., based on the included `package.json`.


## Step 4: Run the Setup Wizard (Ayuco)

Ayuco is the CLI powerhouse for WPMVC. It configures your project (namespace, type: plugin/theme, etc.) and generates boilerplate.

Run:

```bash
php ayuco setup
```

Follow the interactive prompts:

* Project type (plugin or theme)
* Namespace (e.g., `MyAwesomePlugin`)
* Plugin/Theme name, description, author, etc.
* Other config options (database prefix handling, etc.)

After setup:

* Your `app/` folder will contain `Config/`, `Controllers/`, `Models/`, `Views/`, etc.
* `ayuco` executable is ready for more commands (e.g., `php ayuco make:controller`, `php ayuco cache:clear`).
* Basic routing, hooks, and asset enqueuing are wired up.

## Step 5: Development Workflow

* Build assets (watch mode for development):

```bash
npm run dev
```

* Build for production:

```bash
npm run build
```

## Troubleshooting

* Composer errors → Ensure no conflicting global plugins `try composer install --no-plugins --no-scripts` first.
* Ayuco not found → Confirm `ayuco` file exists and is executable (`chmod +x ayuco` if needed).
* Namespace issues → Re-run `php ayuco setup` or edit `app/Config/app.php` manually.
* Asset compilation fails → Check Node version; update npm packages with npm update.
* For older docs (v1 structure): [See archived](https://web.archive.org/web/20220630103034/https://www.wordpress-mvc.com/v1/get-started/)

## Next Steps
You've got the foundation! Now explore:

* Configuration – App settings, env, add-ons
* Ayuco – CLI commands for scaffolding, caching, etc.
* Controllers & Routing
* Models & Database
* Views & Templating
* Assets & Gulp