<?php

namespace Amostajo\WPPluginCore\Abstracts;

use Amostajo\WPPluginCore\Contracts\Plugable;
use Amostajo\LightweightMVC\Engine as Engine;

/**
 * Addon abstract class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */
abstract class Addon implements Plugable
{
    /**
     * Plugin object reference.
     * @var object Plugin
     * @since 1.0
     */
    protected $main;

    /**
     * MVC engine.
     * @var object Plugin
     * @since 1.0
     */
    protected $mvc;

    /**
     * Default constructor.
     * @since 1.0
     *
     * @param string $key  Addon full class name.
     * @param object $main Plugin object.
     */
    public function __construct( $key, $main )
    {
        $namespace = explode( '\\', $key );
        unset( $namespace[count( $namespace ) -1] );
        $this->main = $main;
        $this->mvc = new Engine(
            __DIR__ . '/views/',
            __DIR__ . '/controllers/',
            implode( '\\', $namespace )
        );
    }

    /**
     * Called on init.
     * @since 1.0
     * @return void
     */
    public function init()
    {
        // TODO custom code.
    }

    /**
     * Called on admin.
     * @since 1.0
     * @return void
     */
    public function on_admin()
    {
        // TODO custom code.
    }
}
