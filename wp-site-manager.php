<?php
/**
 * Plugin Name: WP Site Manager
 * Plugin URI: http://bonnierpublications.com
 * Description: Service for the site manager
 * Version: 2.0.2
 * Author: Michael Sørensen & Frederik Rabøl
 * Author URI: http://bonnierpublications.com
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return \Bonnier\WP\SiteManager\WpSiteManager $instance returns an instance of the plugin
 */
function loadWpSiteManager()
{
    return \Bonnier\WP\SiteManager\WpSiteManager::instance();
}

add_action('plugins_loaded', 'loadWpSiteManager');
