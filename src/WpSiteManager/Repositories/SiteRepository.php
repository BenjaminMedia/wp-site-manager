<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Http\SiteManagerClient;
use WpSiteManager\Contracts\SiteContract;

/**
 * Class SiteRepository
 * @package WpSiteManager\Repositories
 */
class SiteRepository implements SiteContract
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
            $response = $this->siteManagerClient->get('/api/v1/sites');
        } catch (ClientException $e) {
            return [];
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents())->data :
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
            $response = $this->siteManagerClient->get('/api/v1/sites/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
