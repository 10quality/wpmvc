<?php

namespace WPMVC\Contracts;

/**
 * Plugable contract.
 * Interface for ADDONS.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 1.0.0
 */
interface Plugable
{
    /**
     * Called on Plugin's init function.
     * @since 1.0.0
     */
    public function init();

    /**
     * Called on Plugin's on_admin function.
     * Admin Dashboard.
     * @since 1.0.0
     */
    public function on_admin();
}
