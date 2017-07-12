<?php



/**
 * @return \WpSiteManager\Plugin|null
 */
function wpSiteManager() {
    return isset($GLOBALS['wpSiteManager']) ? $GLOBALS['wpSiteManager'] : null;
}