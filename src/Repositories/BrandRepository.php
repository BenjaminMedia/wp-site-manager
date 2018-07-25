<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Contracts\BrandContract;
use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class SiteRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class BrandRepository implements BrandContract
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
            $response = $this->siteManagerClient->get('/api/v1/brands');
        } catch (ClientException $e) {
            return [];
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents())->data :
            [];
    }

    /**
     * Get site by ID
     * @param $brandId
     * @return array|mixed|null|object
     */
    public function findById($brandId)
    {
        if (is_null($brandId)) {
            return null;
        }
        try {
            $response = $this->siteManagerClient->get('/api/v1/brands/' . $brandId);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
