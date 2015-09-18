<?php

namespace Amostajo\WPPluginCore;

use Amostajo\LightweightMVC\Engine as Engine;

/**
 * Plugin class.
 * To be extended as main plugin class.
 * Part of the core library of Wordpress Plugin.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\LightweightMVC
 */
abstract class Plugin
{
	/**
	 * Configuration file.
	 * @var array
	 */
	protected $config;

	/**
	 * MVC engine.
	 * @var Engine;
	 */
	protected $mvc;

	/**
	 * Main constructor
	 *
	 * @param array $config Configuration options.
	 */
	public function __construct( Config $config )
	{
		$this->config = $config;
		$this->mvc = new Engine(
			$this->config->get('paths.views'),
			$this->config->get('paths.controllers'),
			$this->config->get('namespace')
		);
	}

	/**
	 * Displays view with the parameters passed by.
	 *
	 * @param string $view   Name and location of the view within "theme/views" path.
	 * @param array  $params View parameters passed by.
	 */
	public function view ( $view, $params = array() )
	{
		$this->mvc->view->show( $view, $params );
	}
}