---
sidebar_position: 10
title: Controllers
description: Learn how to create controllers in the WordPress MVC Framework (WPMVC). Organize plugin logic using MVC architecture for scalable WordPress development. 
keywords: [wordpress mvc controller, wordpress plugin controller example, mvc controller wordpress, wordpress mvc framework controllers, wordpress mvc development]
---

<head>
  <title>WordPress MVC Controllers – Build Structured Plugin Logic with WPMVC</title>
</head>
---

# Controllers

Controllers handle business logic and behavior within a **WordPress MVC** (WPMVC) application. They respond to hooks, orchestrate models and views, and encapsulate the application’s control flow.

## Storage Path

Controller classes live under:

```bash
[path to project]/app/Controllers/
```

Each controller corresponds to a PHP class that typically extends the base `Controller` class.

## Generating Controllers (Ayuco)

Use the [Ayuco](cli/ayuco.md) tool to create controllers and methods easily:

```bash
php ayuco create controller:{Controller@method}
```

* `{Controller@method}` — the controller class name

Additional methods can be defined with extra `@method` segments.

Examples

Create a controller `MyController` with one method:

```php
php ayuco create controller:MyController@print_hello_world
```

This produces:

```php title="app/Controlleres/MyController" showLineNumbers
<?php

namespace MyNamespace\Controllers;

use WPMVC\MVC\Controller;

class MyController extends Controller
{
    public function print_hello_world()
    {
    }
}
```

## Controller Basics

Controllers extend the core `Controller` class provided by the framework. They:
* Encapsulate business logic and algorithms.
* Coordinate [models](mvc/models.md) and views.
* Respond to WordPress hooks or handle actions.

## Using Views Inside Controllers

Controllers can render or return [views](mvc/views.md) via the built-in view helper:

```php title="app/Controlleres/MyController"
class MyController extends Controller
{
    public function print_hello_world()
    {
        // Get a rendered view without printing
        $view = $this->view->get( 'hello-world' );

        // Print a view directly
        $this->view->show( 'hello-world' );
    }
}
```

If a controller method is bound to a WordPress action hook, a returned view will be automatically printed.

Example returning a view for an action hook:

```php title="app/Controlleres/MyController"
class MyController extends Controller
{
    /**
     * @hook woocommerce_thankyou
     */
    public function print_hello_world()
    {
        return $this->view->get( 'shortcode.hello-world' );
    }
}
```

## Accessing User Info

Controllers make it easy to access the current logged-in user with $this->user:

```php title="app/Controlleres/MyController"
class MyController extends Controller
{
    public function show_user_info()
    {
        if ($this->user) {
            $this->view->show( 'hello-world', [
                'display_name' => $this->user->display_name,
                'email'        => $this->user->user_email,
            ] );
        }
    }
}
```

This provides standard WordPress user data inside controllers.

## Automated Controllers

WPMVC offers automated controllers for post models that provide extra built-in functionality out-of-the-box, such as:

* Automatically generating meta boxes based on model metadata
* Handling save operations without extra code

How it Works

When you register a **Post Model** and create a controller that extends the `ModelController`, the framework:

1. **Builds a meta box** using the model's configured aliases and a corresponding view template.
2. **Performs model save logic automatically callbacks.**

### Customizing Automated Controllers

Controllers extending the automated base class can override hookable callbacks:

#### on_metabox(&$model)

Called before the meta box is rendered.

```php title="app/Controlleres/MyController"
class MyController extends Controller
{
    protected $model = MyModel::class;

    public function on_metabox( &$model )
    {
        if ( $model->css === 'white' ) {
            $model->css = '#fff';
        }
    }
}
```

#### on_save(&$model)

Called before the model is saved; ideal for custom save logic.

```php title="app/Controlleres/MyController"
public function on_save(&$model)
{
    if ( Request::input( 'force_trash', false) ) {
        $model->post_status = 'trash';
    }
}
```

#### Autosave Support

Controllers can optionally enable WordPress autosave handling:

```php title="app/Controlleres/MyController"
class MyController extends Controller
{
    protected $autosave = true;

    public function on_save(&$model)
    {
        // Custom logic, including during autosave
    }
}
```

Enabling $autosave allows the `on_save` method to be invoked even during WP autosave events.