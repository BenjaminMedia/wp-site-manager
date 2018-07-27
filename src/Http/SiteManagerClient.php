<?php

namespace Bonnier\WP\SiteManager\Http;

use GuzzleHttp\Client;

class SiteManagerClient extends Client
{
    private static $instance;

    public function __construct()
    {
        $host = env('SITE_MANAGER_HOST', '');
        if (!$host) {
            add_action('admin_notices', function () {
                echo sprintf(
                    '<div class="error notice"><p>%s</p></div>',
                    "SITE_MANAGER_HOST not present in the .env file!"
                );
            });
        }
        parent::__construct([
            'base_uri' => $host,
        ]);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
