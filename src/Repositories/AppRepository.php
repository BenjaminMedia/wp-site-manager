<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Contracts\AppContract;
use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class SiteRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class AppRepository implements AppContract
{

    protected $siteManagerClient;

    public function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

    /**
     * Get all sites
     * @return array
     */
    public function getAll()
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/apps');
        } catch (ClientException $e) {
            return [];
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            [];
    }

    /**
     * Get site by ID
     * @param $appId
     * @return array|mixed|null|object
     */
    public function findById($appId)
    {
        if (is_null($appId)) {
            return null;
        }
        try {
            $response = $this->siteManagerClient->get('/api/v1/apps/'.$appId);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
