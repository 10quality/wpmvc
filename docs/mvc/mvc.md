---
sidebar_position: 1
---

# MVC Overview

WordPress MVC (WPMVC) brings the proven **Model-View-Controller (MVC)** pattern to WordPress development, giving you clean separation of concerns for custom themes and plugins.

While WordPress itself is hook-based and procedural, WPMVC layers MVC on top to make your code more organized, maintainable, testable, and scalable — perfect for artisan-level custom work.

## What is MVC?

- **Model** — Handles data and business logic. Interacts with the database (WP posts, options, custom tables), performs validations, and provides methods to fetch/save data.
- **View** — Responsible for presentation. Renders HTML/templates (PHP or Blade), displays data from Models, and includes minimal logic (loops, conditionals).
- **Controller** — Acts as the middleman. Receives requests (via WP hooks, routes, shortcodes), fetches data via [Models](mvc/models.md), prepares it, and passes it to [views](mvc/views.md) for rendering.

## How MVC Fits into WordPress

WPMVC adapts classic MVC to WP's ecosystem:
- **Requests** come from WP actions/filters, admin pages, public URLs, AJAX, shortcodes, etc.
- **Controllers** hook into WP (e.g., `add_action('init', ...)`), handle routing, and coordinate.
- **Models** extend base classes that work with `$wpdb`, WP_Query, options API, users, terms, etc.
- **Views** can be rendered in admin metaboxes, frontend templates, widgets, or via shortcodes.
- **[Assets](resources/assets.md)** (CSS/JS) are enqueued via [controllers](mvc/controllers.md) or config.
- **Add-ons** extend this pattern (e.g., metaboxes auto-generate from Models).

### Request Flow Example
1. User visits `/my-custom-page/` or triggers an admin action.
2. WP fires a hook → WPMVC Controller catches it.
3. Controller queries Model(s) for data.
4. Controller passes data to View.
5. View renders output → sent back via WP.

[Simple diagram placeholder — you could add one via Mermaid or external image]

## Benefits in WPMVC

- Cleaner code: No more 5000-line functions.php files.
- Reusability: Models can be used across plugins/themes.
- Testability: Easier to unit-test Models/Controllers.
- Scalability: Add features without chaos.

Next, dive deeper:
- [Models](./models.md)
- Views
- Controllers