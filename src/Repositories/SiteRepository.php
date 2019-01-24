<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use Bonnier\WP\SiteManager\Contracts\SiteContract;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class SiteRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class SiteRepository implements SiteContract
{

    protected $siteManagerClient;

    public function __construct()
    {
        $this->siteManagerClient = SiteManagerClient::getInstance();
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
     * @param $siteId
     * @return array|mixed|null|object
     */
    public function findById($siteId)
    {
        if (is_null($siteId)) {
            return null;
        }
        try {
            $response = $this->siteManagerClient->get('/api/v1/sites/'.$siteId);
        } catch (ClientException $e) {
            return null;
        } catch (ServerException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
