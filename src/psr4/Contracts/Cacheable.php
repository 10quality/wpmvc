<?php

namespace Amostajo\WPPluginCore\Contracts;

use Closure;

/**
 * Cacheable contract.
 * Interface for Cache class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */
interface Cacheable
{
	/**
	 * Default constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public function __construct( $config );

	/**
	 * Static constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public static function init( $config );

	/**
	 * Returns value stored in cache.
	 * @since 1.0
	 * @param string $key Cache key name.
	 */
	public static function get( $key );

	/**
	 * Adds a value to cache.
	 * @since 1.0
	 * @param string $key     Main plugin object as reference.
	 * @param mixed  $value   Value to cache.
	 * @param int  	 $expires Expiration time in minutes.
	 */
	public static function add( $key, $value, $expires );

	/**
	 * Returns flag if a given key has a value in cache or not.
	 * @since 1.0
	 * @param string $key Cache key name.
	 * @return bool
	 */
	public static function has( $key );

	/**
	 * Returns the value of a given key.
	 * If it doesn't exist, then the value pass by is returned.
	 * @since 1.0
	 * @param string  $key     Main plugin object as reference.
	 * @param int  	  $expires Expiration time in minutes.
	 * @param Closure $value   Value to cache.
	 * @return mixed
	 */
	public static function remember( $key, $expires, Closure $value );

	/**
	 * Removes a key / value from cache.
	 * @since 1.0
	 * @param string $key Cache key name.
	 */
	public static function forget( $key );

	/**
	 * Flushes all cache keys and values.
	 * @since 1.0
	 */
	public static function flush();
}