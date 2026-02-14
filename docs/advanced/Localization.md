---
sidebar_position: 1
---

# Localization

The framework supports **WordPress** localization files (`.pot`, `.po`, and `.mo` files).

By default, localization files should be stored in the folder `[project]/assets/lang`.

## Text Domain

Localization in **WordPress** works by text domains. These domains are attached to each custom text string found inside the code of a plugin or theme and help **WordPress** know who will translate them.

WordPress expects the domain owner to provide it with PO language files that will be used for translations.

Define your text-domain based on your namespace. WordPress.org will assign you a text-domain (slug) if you plan to publish the project on their website.

## Ayuco Command

[Ayuco](/cli/ayuco.md) asks for a text-domain during the **setup command**.

Alternatively, the text domain can be changed by using the **set command**:

```bash
php ayuco set domain:{text-domain}
```

Example:

```bash
php ayuco set domain:my-awesome-plugin
```

This updates the text domain in `app/Config/app.php` and ensures proper loading.

## Built-in POT/PO/MO Generation Commands

WPMVC (via the wpmvc-commands package integrated with Ayuco) includes native commands to generate and manage translation files without external tools like Poedit, WP-CLI, or Loco Translate. These commands scan your project files (PHP controllers, models, views, etc.) for translatable strings (`__()`, `_e()`, `esc_html__()`, etc.) and create/update files automatically using WordPress gettext standards.

### Key Commands

Run these from your project root:

#### Generate POT template

(scans code and creates/updates the base `.pot` file):

```bash
php ayuco generate pot
```

This creates/updates `assets/lang/{text-domain}.pot` with all found strings. It uses your configured text domain from `app/Config/app.php`.

#### Generate PO file

Generate PO file for a specific language (e.g., Spanish):

```bash
php ayuco generate po:{locale}
```

Example:

```bash
php ayuco generate po:es_ES
```

This generates `assets/lang/{text-domain}-es_ES.po` (if missing) or merges new strings from the latest `.pot` into an existing `.po`. You can then edit translations in the `.po` file.

#### Generate MO file

Generate MO file for a specific language (e.g., Spanish):

```bash
php ayuco generate mo:{locale}
```

Example:

```bash
php ayuco generate mo:es_ES
```

This produces `assets/lang/{text-domain}-es_ES.mo` from the corresponding `.po`. Run this after editing translations.

#### Interactive Translation Wizard (PO + MO Generation)

The most powerful tool is the interactive wizard that scans for strings and prompts you to translate each one directly in the terminal:

```bash
php ayuco generate translations:{locale}
```

Example for Spanish:

```bash
php ayuco generate translations:es_ES
```

* It first ensures a current `.pot` exists (or prompts to generate one).
* Then scans your code for translatable strings.
* For each string (original text), it prompts:
  * The context/file where it was found.
  * The original string.
  * A field to enter the translation (or press Enter to skip/keep original).
* After all prompts, it generates/updates `assets/lang/{text-domain}-{locale}.po`.
* Finally, it compiles the `.po` into `assets/lang/{text-domain}-{locale}.mo` automatically.

This wizard makes translation fast and code-aware — ideal for small-to-medium projects or quick initial translations.

### Exclusions

Generation commands automatically exclude common directories (e.g., `vendor/`, `node_modules/`, `builds/`, `tests/`) and files that shouldn't contain translatable strings. Additional custom exclusions can be configured if needed (via command options or project config in advanced setups).

Example:

```php title="app/Config/app.php"
'localize' => [
    ...,
    'translations' => [
        'file_exclusions' => ['excluded.php', 'excluded.js'],
    ],
],
```

## Full Workflow Example

1. Set/update text domain:
```bash
php ayuco set domain:my-awesome-plugin
```
2. Add translatable strings in code:
```php
echo __( 'Hello, world!', 'my-awesome-plugin' );
_e( 'Settings saved.', 'my-awesome-plugin' );
```
3. Generate base POT (if needed):
```bash
php ayuco generate pot
```
4. Run interactive wizard for Spanish:
```bash
php ayuco generate translations:es_ES
```
  * Answer prompts for each string (e.g., translate "Hello, world!" to "¡Hola, mundo!").
  * Skip strings that don't need translation.
5. Test: Switch site language to Spanish in WP Admin → Settings → General → strings appear translated.

These commands make i18n fully self-contained in WPMVC — no need for external apps like Poedit or WP-CLI.

## Configuration

Localization settings can be modified in the configuration file (app/Config/app.php or a dedicated localize file).

```php title="app/Config/app.php"
return [
    // Other settings ...
    'localize' => [
        // Enables or disables localization
        'enabled'       => true,
        // Default path for language files
        'path'          => __DIR__ . '/../../assets/lang/',
        // Text domain
        'textdomain'    => 'my-awesome-plugin',
        // Unload loaded locale files before localization
        'unload'        => false,
        // Flag that indicates if this is a WordPress.org plugin/theme
        'is_public'     => false,
    ],
    // Other settings ...
];
```
Do not change the text-domain manually, use Ayuco instead.

The framework automatically loads language files via the text domain and path defined in config.

## Best Practices

* Run `generate pot` after adding new strings to refresh the template.
* Use `generate translations:{locale}` for interactive, guided translation — perfect for developers/translators working together.
* Store `.pot`, `.po`, and compiled `.mo` files in `/assets/lang/`.
* For WordPress.org submissions (`'is_public' => true`), follow their guidelines on text domain matching the plugin slug.
* Disable localization (`'enabled' => false`) during development if not needed to reduce overhead.
* Test translations by changing site language in WP Admin → Settings → General.

Localization in WPMVC is powerful and developer-friendly — Ayuco handles setup, generation, and interactive translation, enabling multilingual plugins/themes with zero external dependencies.