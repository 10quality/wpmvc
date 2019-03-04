<?php

use WPMVC\Config;

/**
 * This file will load configuration file and init Main class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package WPMVC
 * @version 2.0.1
 */

require_once( __DIR__ . '/../../vendor/autoload.php' );

$config = include( plugin_dir_path( __FILE__ ) . '../Config/app.php' );

$plugin_namespace = $config['namespace'];

$plugin_name = strtolower( explode( '\\' , $plugin_namespace )[0] );

$plugin_class = $plugin_namespace . '\Main';

$plugin_reflection = new ReflectionClass( get_parent_class( $plugin_class ) );

// Global class init
$$plugin_name = new $plugin_class( new Config( $config ) );

// Unset
unset($plugin_reflection);
unset($plugin_namespace);
unset($plugin_name);
unset($plugin_class);
unset($config);