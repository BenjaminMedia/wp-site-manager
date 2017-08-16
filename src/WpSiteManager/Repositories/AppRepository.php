<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Contracts\AppContract;
use WpSiteManager\Http\SiteManagerClient;

/**
 * Class SiteRepository
 * @package WpSiteManager\Repositories
 */
class AppRepository implements AppContract
{

    protected $siteManagerClient;

    function __construct()
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
     * @param $id
     * @return array|mixed|null|object
     */
    public function findById($id)
    {
        if(is_null($id)) {
            return null;
        }
        try {
            $response = $this->siteManagerClient->get('/api/v1/apps/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
