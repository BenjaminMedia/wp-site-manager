<?php

namespace Bonnier\WP\SiteManager\Http;

use GuzzleHttp\Client;

class SiteManagerClient extends Client
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => getenv('SITE_MANAGER_HOST'),
        ]);
    }
}
