<?php

namespace Amostajo\WPPluginCore;

use Closure;
use PHPFastCache\phpFastCache;
use Amostajo\WPPluginCore\Contracts\Cacheable;

/**
 * Cache class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */
class Cache implements Cacheable
{
	/**
	 * Fast cache class engine.
	 */
	protected static $fastcache;

	/**
	 * Default constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public function __construct( $config )
	{
		if ( ! isset( self::$fastcache )
			&& $config->get( 'cache' )
		) {
			// Create folder
			if ( ( $config->get( 'cache.storage' ) == 'auto'
				|| $config->get( 'cache.storage' ) == 'files' )
				&& ! is_dir( $config->get( 'cache.path' ) )
			) {
				mkdir( $config->get( 'cache.path' ), 0777, true );
			}
			// Init cache
			phpFastCache::setup( $config->get( 'cache' ) );
			self::$fastcache = phpFastCache();
			phpFastCache::$disabled = !$config->get( 'cache.enabled' );
		}
	}

	/**
	 * Static constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public static function init( $config )
	{
		new self( $config );
	}

	/**
	 * Returns Cache instance.
	 * @since 1.0
	 * @return mixed.
	 */
	public static function instance()
	{
		return isset( self::$fastcache ) ? self::$fastcache : false;
	}

	/**
	 * Returns value stored in cache.
	 * @since 1.0
	 * @param string $key Cache key name.
	 */
	public static function get( $key )
	{
		$cache = self::instance();
		if ( $cache ) {
			return $cache->get( $key );
		}
		return;
	}

	/**
	 * Adds a value to cache.
	 * @since 1.0
	 * @param string $key     Main plugin object as reference.
	 * @param mixed  $value   Value to cache.
	 * @param int  	 $expires Expiration time in minutes.
	 */
	public static function add( $key, $value, $expires )
	{
		$cache = self::instance();
		if ( $cache && $value != null) {
			$cache->set( $key, $value, $expires * 60 );
		}
	}

	/**
	 * Returns flag if a given key has a value in cache or not.
	 * @since 1.0
	 * @param string $key Cache key name.
	 * @return bool
	 */
	public static function has( $key )
	{
		$cache = self::instance();
		if ( $cache ) {
			return $cache->isExisting( $key );
		}
		return false;
	}

	/**
	 * Returns the value of a given key.
	 * If it doesn't exist, then the value pass by is returned.
	 * @since 1.0
	 * @param string  $key     Main plugin object as reference.
	 * @param int  	  $expires Expiration time in minutes.
	 * @param Closure $value   Value to cache.
	 * @return mixed
	 */
	public static function remember( $key, $expires, Closure $closure )
	{
		$cache = self::instance();
		if ( $cache ) {
			if ( $cache->isExisting( $key ) ) {
				return $cache->get( $key );
			} else if ( $closure != null ) {
				$value = $closure();
				$cache->set( $key, $value, $expires * 60 );
				return $value;
			}
		}
		return $closure();
	}

	/**
	 * Removes a key / value from cache.
	 * @since 1.0
	 * @param string $key Cache key name.
	 */
	public static function forget( $key )
	{
		$cache = self::instance();
		if ( $cache ) {
			$cache->delete( $key );
		}
	}

	/**
	 * Flushes all cache keys and values.
	 * @since 1.0
	 */
	public static function flush()
	{
		$cache = self::instance();
		if ( $cache ) {
			$cache->clean();
		}
	}
}
