<?php

namespace MyApp;

use WPMVC\Bridge;

/**
 * Main class.
 * Bridge between WordPress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author fill
 * @package fill
 * @version fill
 */
class Main extends Bridge
{
    /**
     * Declaration of public WordPress hooks.
     */
    public function init()
    {
        // Sample
        // $this->add_action( 'the_content', 'PostController@filter' );
    }
    /**
     * Declaration of admin only WordPress hooks.
     * For WordPress admin dashboard.
     */
    public function on_admin()
    {
        // Sample
        // $this->add_action( 'save_post', 'PostController@save' );
    }
}