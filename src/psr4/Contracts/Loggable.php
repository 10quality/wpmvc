<?php

namespace Amostajo\WPPluginCore\Contracts;

use Amostajo\WPPluginCore\Config;

/**
 * Loggable contract.
 * Interface for Log class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */
interface Loggable
{
	/**
	 * Default constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public function __construct( Config $config );

	/**
	 * Static constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public static function init( Config $config );

	/**
	 * Prints message information in log.
	 * @since 1.0
	 * @param string $message Message information to display in log.
	 */
	public static function info( $message );

	/**
	 * Debugs / prints value in log.
	 * @since 1.0
	 * @param mixed $message Message to debug.
	 * @param array $values  Value(s) to debug.
	 */
	public static function debug( $message, $values = [] );

	/**
	 * Prints error log.
	 * @since 1.0
	 * @param mixed $e Exception / error.
	 */
	public static function error( $e );
}