<?php

namespace Amostajo\WPPluginCore;

use ReflectionClass;
use Amostajo\WPPluginCore\Contracts\Plugable;
use Amostajo\LightweightMVC\Engine;

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
     * @param object $main Plugin object.
     */
    public function __construct( $main )
    {
        $reflection = new ReflectionClass($this);
        $this->main = $main;
        $this->mvc = new Engine(
            dirname( $reflection->getFileName() ) . '/views/',
            dirname( $reflection->getFileName() ) . '/controllers/',
            $reflection->getNamespaceName()
        );
    }

    /**
     * Called on init.
     * @since 1.0
     *
     * @param object &$main Main plugin object as reference.
     *
     * @return void
     */
    public function init()
    {
        // TODO custom code.
    }

    /**
     * Called on admin.
     * @since 1.0
     *
     * @param object &$main Main plugin object as reference.
     *
     * @return void
     */
    public function on_admin()
    {
        // TODO custom code.
    }
}
