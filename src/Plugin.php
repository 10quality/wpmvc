<?php

namespace Amostajo\WPPluginCore;

use Amostajo\WPPluginCore\Contracts\Plugable;
use Amostajo\LightweightMVC\Engine as Engine;

/**
 * Plugin class.
 * To be extended as main plugin / theme class.
 * Part of the core library of Wordpress Plugin / Wordpress Theme.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.2
 */
abstract class Plugin implements Plugable
{
	/**
	 * Configuration file.
	 * @var array
	 * @since 1.0
	 */
	protected $config;

	/**
	 * MVC engine.
	 * @var object Engine
	 * @since 1.0
	 */
	protected $mvc;

	/**
	 * Add ons.
	 * @var array
	 * @since 1.2
	 */
	protected $addons;

	/**
	 * Main constructor
	 * @since 1.0
	 *
	 * @param array $config Configuration options.
	 */
	public function __construct( Config $config )
	{
		$this->config = $config;
		$this->mvc = new Engine(
			$this->config->get( 'paths.views' ),
			$this->config->get( 'paths.controllers' ),
			$this->config->get( 'namespace' )
		);
		$this->addons = array();
		$this->set_addons();
	}

	/**
	 * Returns READ-ONLY properties.
	 * @since 1.2
	 *
	 * @param string $property Property name.
	 *
	 * @return mixed
	 */
	public function __get( $property )
	{
		if ( property_exists( $this, $property ) ) {
			switch ( $property ) {
				case 'config':
					return $this->$property;
			}
		}
		return null;
	}

	/**
	 * Calls to class or addon method.
	 * Checks "addon_" prefix to search for addon methods.
	 * @since 1.2
	 *
	 * @return mixed
	 */
	public function __call( $method, $args )
	{
		if ( preg_match( '/addon\_/', $method ) ) {
			$method = preg_replace( '/addon\_/', '', $method );
			// Search addons
			for ( $i = count( $this->addons ) - 1; $i >= 0; --$i ) {
				if ( method_exists( $this->addons[$i], $method ) ) {
					call_user_func_array( [ $this->addons[$i], $method ], $args );
					break;
				}
			}
		} else {
			call_user_func_array( [ $this, $method ], $args );
		}
	}

	/**
	 * Sets plugin addons.
	 * @since 1.2
	 *
	 * @return void
	 */
	protected function set_addons()
	{
		if ( $this->config->get( 'addons' ) ) {
			foreach ( $addons as $addon ) {
				$addons[] = new $addon( $addon, $this );
			}
		}
	}

	/**
	 * Displays view with the parameters passed by.
	 * @since 1.1
	 *
	 * @param string $view   Name and location of the view within "theme/views" path.
	 * @param array  $params View parameters passed by.
	 *
	 * @return void
	 */
	public function view( $view, $params = array() )
	{
		$this->mvc->view->show( $view, $params );
	}

	/**
	 * Called by autoload to init class.
	 * @since 1.2
	 * @return void
	 */
	public function autoload_init()
	{
		$this->init();
		// Addons
		for ( $i = count( $this->addons ) - 1; $i >= 0; --$i ) {
			$this->addons[$i]->init();
		}
	}

	/**
	 * Called by autoload to init on admin.
	 * @since 1.2
	 * @return void
	 */
	public function autoload_on_admin()
	{
		$this->on_admin();
		// Addons
		for ( $i = count( $this->addons ) - 1; $i >= 0; --$i ) {
			$this->addons[$i]->on_admin();
		}
	}

	/**
	 * Init.
	 * @since 1.2
	 * @return void
	 */
	public function init()
	{
		// TODO custom code.
	}

	/**
	 * On admin Dashboard.
	 * @since 1.2
	 * @return void
	 */
	public function on_admin()
	{
		// TODO custom code.
	}
}
