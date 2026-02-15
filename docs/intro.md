---
sidebar_position: 1
---

# Introduction

## Welcome to WordPress MVC

**WordPress MVC** (WPMVC) is the ultimate framework crafted for web artisans who demand elegance, structure, and control when building custom themes and plugins for WordPress.

Tired of tangled functions.php files, scattered plugin code, or fighting WordPress conventions to create something truly bespoke? WPMVC brings true **MVC architecture** (Models, Views, Controllers) directly into WordPress — giving you the organization and power of modern frameworks while staying fully compatible with the WordPress ecosystem.

### Why Choose WordPress MVC?

Designed by **10Quality** for developers who treat code as craft, this framework empowers you to:

- Build **clean, maintainable** custom themes and plugins with clear separation of concerns  
- Leverage WordPress hooks (actions, filters), shortcodes, widgets, and core features seamlessly  
- Manage **assets** (CSS, JS, images) efficiently with modern build tools (npm, Composer)  
- Use **Ayuco** scaffolding for rapid setup and code generation  
- Extend functionality through a growing ecosystem of **add-ons** (admin panels, metaboxes, licensing, resources, etc.)  
- Deploy professional-grade solutions faster — without sacrificing WordPress flexibility  

Whether you're creating enterprise-level plugins, premium themes, or tailored client solutions, WordPress MVC lets you focus on artistry and innovation instead of boilerplate and hacks.

> "The ultimate WordPress framework for custom Themes and Plugins development."  
> — Official tagline (GitHub)

## Philosophy

WordPress MVC (WPMVC) exists to **enhance**, not replace, WordPress.

WordPress is — and should remain — an **event-driven, hook-based ecosystem**. Its power lies in its extensibility through actions, filters, shortcodes, widgets, templates, and the plugin/theme API. WPMVC does not attempt to abstract away or rewrite this foundation with a full request router, middleware pipeline, or centralized lifecycle controller. Instead, it embraces WordPress exactly as it is and provides tools to make custom development inside that ecosystem cleaner, more structured, and more enjoyable.

### Core Principles

- **Respect WordPress execution flow**  
  WPMVC routes **hooks**, not requests. Output happens through shortcode callbacks, template includes, widget rendering, admin page callbacks, content filters, and other native WP mechanisms. There is no `Response::view()` or forced view rendering — controllers prepare data and delegate to views only when it makes sense within WordPress's flow.

- **True MVC inside WordPress constraints**  
  Models handle data & business logic, Views handle presentation (plain PHP files in `assets/views/`), Controllers coordinate — but always return strings or void when required by WP (e.g., shortcode return, admin page echo/include). No magic that breaks compatibility or future WP updates.

- **Artisan craftsmanship over framework imposition**  
  The framework gives developers structure (namespaces, autoloading, Ayuco scaffolding, config-driven assets, secure request wrappers) without forcing a foreign paradigm. Code should feel like elegant WordPress, not like Laravel-inside-WordPress.

- **Security & simplicity first**  
  Static `Request::input()`, automatic sanitization, nonce helpers, cache prefixing, and asset auto-enqueuing reduce boilerplate and common mistakes without introducing new abstractions that could conflict with core.

- **Decentralized & maintainable assets**  
  Views, CSS, JS, images, translations — everything presentation-related lives in `assets/`. No inline `<style>` or `<script>` in templates. Use the Gulp pipeline and auto-enqueue for clean, cache-friendly delivery.

WPMVC is built for developers who love WordPress but hate writing the same hook boilerplate, security checks, and disorganized code over and over again. It gives you the organization of modern MVC without asking WordPress to stop being WordPress.

> "Enhance WordPress. Don't replace it."

Get started in minutes: install via Composer, run the setup wizard, and start building like a true web artisan.

* [Getting Started →](./category/getting-started)
* [GitHub Repository →](https://github.com/10quality/wpmvc)

Let's craft something extraordinary.