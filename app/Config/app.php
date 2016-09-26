<?php

/**
 * App configuration file.
 */
return [

    'namespace' => 'App',

    'type' => 'theme',

    'paths' => [

        'controllers'   => __DIR__ . '/../Controllers',
        'views'         => __DIR__ . '/../../assets/views',
        'log'           => get_home_path() . './wpmvc/log',

    ],

    'cache' => [

        // Enables or disables cache
        'enabled'       => true,
        // files, auto (files), apc, wincache, xcache, memcache, memcached
        'storage'       => 'auto',
        // Default path for files
        'path'          => get_home_path() . './wpmvc/cache',
        // It will create a path by PATH/securityKey
        'securityKey'   => '',
        // FallBack Driver
        'fallback'      => [
                            'memcache'  =>  'files',
                            'apc'       =>  'sqlite',
                        ],
        // .htaccess protect
        'htaccess'      => true,
        // Default Memcache Server
        'server'        => [
                            [ '127.0.0.1', 11211, 1 ],
                        ],

    ],

    'addons' => [],

];