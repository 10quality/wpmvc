---
sidebar_position: 20
---

# Views

Views in **WordPress MVC** (WPMVC) are templates responsible for generating the HTML output displayed to the user. They are essentially frontend assets that receive data (variables) from controllers and render markup accordingly.

## Overview

A view file:

* Is a PHP file containing primarily HTML — PHP should only be used to echo dynamic data passed from a controller.
* Represents a clean separation between presentation and business logic (logic belongs in controllers).
* Can be thought of as the template layer in the MVC pattern.

## Storage Path

Views are stored under the project’s view directory. For example:

```bash
[path to project]/assets/views/
```

## Ayuco Command

You can scaffold a new view using Ayuco:

```bash
php ayuco create view:{view-key}
```

- `{view-key}` –> A key identifying your view.

Example:

```bash
php ayuco create view:shortcodes.hello-world
```

This creates a view at:

```bash
assets/views/shortcodes/hello-world.php
```

## Example View

A simple view could look like this:

```html title="assets/views/book.php" showLineNumbers
<div class="book book-<?php echo $book->ID ?>">
  <h1><?php echo $book->title ?></h1>
  <ul>
    <li>Year: <?php echo $book->year ?></li>
    <li>Publisher: <?php echo $book->publisher ?></li>
  </ul>
  <p><?php echo $book->description ?></p>
</div>
```

## Parameters

All view invocation methods allow passing parameters as an associative array. These keys are converted into PHP variables available inside the view.

Example of passing parameters from a controller:

```php
// Call a view and pass parameters
get_bridge( 'theme' )->view( 'view.key', [
    'parameter_name_1' => 1,
    'my_model'         => MyModel::find( 1 ),
    'db_option'        => get_option( 'db_option' ),
] );
```

Inside the view, these become local variables:

```html
<?php echo $parameter_name_1 ?>
<?php echo $my_model->title ?>
<?php print_r($db_option) ?>
```

This delivers clean separation data → view.

## Calling Views

Views can be rendered from different contexts:

### Within a Controller

```php
class MyController extends Controller
{
    public function my_function() {
        // get returns view content without printing
        $view = $this->view->get( 'view.key' );

        // show prints the view directly
        $this->view->show( 'view.key-2', [
            'param1' => true,
            'model' => MyModel::find()
        ] );
    }
}

```

### Within the Main Class

```php
class Main extends Bridge {
    public function return_view() {
        return $this->mvc->view->get( 'view.key' );
    }
}
```

### Global Helper Functions

* `get_bridge('MyNamespace')->view('view.key', $params)`
* In themes: `theme_view('view.key', $params)` (theme-specific helper).

## Theme Overrides

Plugin views can be overridden in a theme or child theme. To do this:

1. Copy the plugin’s view file into the theme with the same relative folder tructure.
2. The framework will prioritize the theme copy over the plugin view.

Example:

Original plugin view:

```bash
{plugin root}/assets/views/shortcodes/hello-word.php
```

Theme override:

```bash
{theme root}/assets/views/shortcodes/hello-word.php
```

The override is loaded automatically. You can even customize the theme base path using configuration (e.g., via `paths.theme_path`).

Example:

```php
'paths' => [
    ...,
    'theme_path' => '/my-app/',
],
```

This would look for views in:
```bash
{theme root}/my-app/shortcodes/hello-word.php
```

## Best practices

* A view should only contain frontend code (HTML with PHP echoes).
* Keep business logic and algorithms out of views; controllers are responsible for that.