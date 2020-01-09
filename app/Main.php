<?php

namespace MyApp;

use WPMVC\Bridge;

/**
 * Main class.
 * Bridge between WordPress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author fill
 * @version fill
 */
class Main extends Bridge
{
    /**
     * Declaration of public WordPress hooks.
     * @since fill version
     */
    public function init()
    {
        // Sample
        // $this->add_action( 'the_content', 'PostController@filter' );
    }
    /**
     * Declaration of admin only WordPress hooks.
     * For WordPress admin dashboard.
     * @since fill version
     */
    public function on_admin()
    {
        // Sample
        // $this->add_action( 'save_post', 'PostController@save' );
    }
}