<?php

namespace WpSiteManager\Services;

use GuzzleHttp\Client;

class SiteManagerService extends Client
{
    public $client;

    public function __construct()
    {
        parent::__construct([
            'base_uri' => getenv('SITE_MANAGER_HOST')
        ]);
    }

    public static function getInstance() {
        if(self::$client === null) {
            self::$client = new static();
        }
        return self::$client;
    }
}