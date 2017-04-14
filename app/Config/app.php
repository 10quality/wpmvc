<?php

/**
 * App configuration file.
 */
return [

    'namespace' => 'MyApp',

    'type' => 'theme',

    'paths' => [

        'base'          => __DIR__ . '/../',
        'controllers'   => __DIR__ . '/../Controllers/',
        'views'         => __DIR__ . '/../../assets/views/',
        'log'           => get_wp_home_path() . './wpmvc/log',

    ],

    'version' => '1.0.0',

    'autoenqueue' => [

        // Enables or disables auto-enqueue of assets
        'enabled'       => true,
        // Assets to auto-enqueue
        'assets'        => [
                            [
                                'asset'     => 'css/app.css',
                                'dep'       => [],
                                'footer'    => false,
                            ],
                            [
                                'asset'     => 'js/app.js',
                                'dep'       => [],
                                'footer'    => true,
                            ],
                        ],

    ],

    'cache' => [

        // Enables or disables cache
        'enabled'       => true,
        // files, auto (files), apc, wincache, xcache, memcache, memcached
        'storage'       => 'auto',
        // Default path for files
        'path'          => get_wp_home_path() . './wpmvc/cache',
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