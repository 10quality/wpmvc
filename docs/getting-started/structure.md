---
sidebar_position: 5
---

# File Structure

**WordPress MVC** (WPMVC) follows a clean, convention-based directory layout designed for maintainability, scalability, and separation of concerns. After installing via Composer and running the Ayuco setup wizard (`php ayuco setup`), your project (plugin or theme) will have the following typical structure.

```text
my-awesome-plugin-or-theme/                 # Root folder (plugin folder name or theme folder)
├── assets/                                 # All static frontend and admin files
│   ├── css/                                # Compiled CSS files
│   ├── js/                                 # Compiled JavaScript files
│   ├── img/                                # Images, icons, SVGs
│   ├── fonts/                              # Custom fonts
│   ├── lang/                               # Translation files (.pot, .po, .mo)
│   ├── raw/                                # Source files for asset compilation (Gulp)
│   │   ├── css/                            # Raw CSS before concatenation/minification
│   │   ├── js/                             # Raw JavaScript before bundling
│   │   └── sass/                           # SCSS/SASS source files
│   └── views/                              # View files
├── app/                                    # Core application code — the MVC heart (PSR-4)
│   ├── Config/                             # Configuration files
│   │   └── app.php                         # Main app settings (namespace, version, cache, autoenqueue, localize…)
│   ├── Controllers/                        # MVC Controllers
│   │   ├── PublicController.php            # Public-facing logic
│   │   └── Admin/                          # Admin-area controllers
│   ├── Models/                             # Data models (post, user, term, option, comment, custom tables)
│   ├── Widgets/                            # (OPTIONAL) Custom widget classes
│   └── Main.php                            # Main.php (hooks router)
├── tests/                                  # PHPUnit tests (if you ran `php ayuco setup tests`)
├── vendor/                                 # Composer dependencies (wpmvc-core, ayuco, etc.)
├── node_modules/                           # npm dependencies for Gulp asset pipeline
├── .gitignore
├── composer.json                           # Composer dependencies & autoloading
├── package.json                            # npm scripts & Gulp dependencies
├── gulpfile.js                             # Asset compilation & build tasks
├── ayuco                                   # Ayuco CLI executable (make sure chmod +x ayuco)
├── functions.php                           # (THEME ONLY) Main theme entry file (minimal bootstrap)
├── style.css                               # (THEME ONLY) Main theme indentifier file (minimal bootstrap)
├── plugin.php                              # (PLUGIN ONLY) Main plugin entry file (minimal bootstrap)
└── readme.txt                              # Standard WordPress plugin readme
```

Key Folders Explained

* `assets/`
  Contains your front-end files.
  * `views/` → Presentation templates.
  * `raw/` → Source files (unminified CSS/JS/SCSS).
  * Compiled/minified output goes to `css/` and `js/`.
  * Auto-enqueue is managed via `app/Config/app.php` (e.g., `app.css`, `app.js`).
* `app/`
  Contains your back-end files. The heart of your custom code.
  * `Config/` → All project settings.
  * `Controllers/` → Business logic and request handling.
  * `Models/` → Data access and business rules.
* **Root files**
  * `plugin.php` → The WordPress entry point for plugins. Usually very thin — just loads Composer autoloader and calls the framework bootstrap.
  * `functions.php` → The WordPress entry point for themes. Usually very thin — just loads Composer autoloader and calls the framework bootstrap.
  * `styles.css` → WordPress identity file for themes.
  * `ayuco` → Command-line tool for scaffolding, generation, and maintenance.
  * `composer.json` + `package.json` → Dependency management for PHP (Composer) and frontend (npm/Gulp).

This structure keeps WordPress boilerplate minimal while giving you a modern, MVC-organized codebase — perfect for artisan-level plugin and theme development.

## Next steps

* Run `php ayuco setup` after installation to scaffold your namespace and initial files.
* Use Ayuco commands (`php ayuco create controller`, etc.) to generate files in the right places.
* Compile assets with `gulp watch` (watch mode) or `gulp build` (production).