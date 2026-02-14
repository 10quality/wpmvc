---
sidebar_position: 1
---

# Ayuco

> The Command-Line Powerhouse for WordPress MVC

Ayuco is the built-in **command-line interface (CLI)** for WordPress MVC (WPMVC). It serves as the primary scaffolding tool, allowing you to rapidly generate boilerplate code, register components, add hooks, configure project settings, and more — all while following the framework's conventions.

Think of Ayuco as your artisan assistant: it automates repetitive tasks so you can focus on crafting high-quality custom themes and plugins.

- **Runs via PHP** from your project root.
- **Interactive wizards** (e.g., setup).
- **Supports custom commands** for extensibility.
- Included automatically when you install WPMVC via Composer.

> Ayuco is part of the core WPMVC experience — no separate installation needed after `composer require 10quality/wpmvc` or `create-project`.

## Basic Usage

Navigate to your project's root directory (where the `ayuco` file lives) and run commands like this:

```bash
php ayuco {command} [arguments] [options]
```

Examples:

```bash
php ayuco help                  # List all available commands
php ayuco setup                 # Run the interactive setup wizard
php ayuco create:model Book       # (Modern alias; see below for v1 syntax)
```

**Important notes:**

* Always execute from the project root.
* Use options like `--comment="Description"` to add inline docs.
* `--nopretty` skips code formatting (useful if you have custom style rules).
* `--void` removes `@return` tags in generated methods (for void handlers).
* `--audit` adds creation timestamps to comments (handy for tracking changes).

## Available Commands

Ayuco organizes commands into categories like `setup`, `add`, `create`, `register`, `set`, etc. (v1 syntax shown; newer versions may use aliases like make: or generate: — run php ayuco help for your installed version).

### help

Displays the full list of registered commands and brief descriptions.

```bash
php ayuco help
```

### setup

Runs the interactive setup wizard to configure your project (namespace, type: plugin/theme, etc.).

```bash
php ayuco setup
```
Variants:

* `php ayuco setup` → Standard framework setup wizard.
* `php ayuco setup tests` → Sets up PHPUnit + WordPress Test Suite for unit testing.

### add

Adds WordPress hooks (actions, filters, shortcodes) and wires them to controllers or views.

```bash
php ayuco add {object}:{name} {handler} [options]
```

Common objects:
* `action` — Add an action hook (e.g., `init`, `wp_enqueue_scripts`).
* `filter` — Add a filter hook.
* `shortcode` — Register a shortcode.

Example:

```bash
php ayuco add action:init ConfigController@init --comment="Initializes app settings" --audit
```
Handler format: `Controller@method` or view path.

### create

Generates files for models, views, controllers, and assets.

```bash
php ayuco create {object}:{name} [params] [options]
```

Common objects:

* `view` — Creates a view file (e.g., `admin.metaboxes.custom`).
controller — New controller class.
* `model` — Standard model.
* `postmodel` — Model backed by WP Posts (param: post type).
* `optionmodel` — Model backed by WP Options (param: option ID).
* `usermodel` — Model for users.
* `termmodel` — Model for terms/taxonomies (optional: taxonomy name).
* `commentmodel` — Model for comments.
* `js` / `css` / `sass` / `scss` — Asset files (sass/scss can specify master import).

Example:

```bash
php ayuco create model:Book --comment="Handles book data"
php ayuco create view:frontend.venues.show
php ayuco create sass:admin --import "master"
```

### register

Registers components like widgets, custom post types, models, and assets.

```bash
php ayuco register {object}:{name} [params] [options]
```

Common objects:

* `widget` — New widget class.
* `type` — Custom post type + auto model/controller (params: model class, controller class).
* `model` — Register an existing model.
* `asset` — Enqueue an asset (e.g., css/admin.css).

Example:

```bash
php ayuco register widget:HelloWorldWidget --comment="Simple greeting widget"
php ayuco register type:Event EventModel EventController
```

### set

Updates project metadata in config files.

```bash
php ayuco set {object}:{value}
```

* `version:1.2.3`
* `domain:my-text-domain`
* `author:Your Name <email@example.com>`
* `namespace:New\Namespace`
* `license:MIT`

Example:

```bash
php ayuco set version:2.0.0
php ayuco set namespace:MyAwesome\Plugin
```

### prettify

Formats all PHP files in the `/app` folder (PSR-2 + WordPress style mix).

```bash
php ayuco prettify
```

## Tips & Best Practices

* Always run `php ayuco help` after updates to see the current command list (commands can evolve with framework versions).
* Generated code is opinionated — review and tweak as needed.
* Use `--comment` liberally for self-documenting code.

Ayuco turns hours of boilerplate into minutes of scaffolding. Use it to build faster and cleaner!