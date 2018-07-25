<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Contracts\TagContract;
use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use GuzzleHttp\Exception\ClientException;

/**
 * Class TagRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class TagRepository implements TagContract
{
    protected $siteManagerClient;

    public function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

    /**
     * Get all tags
     * @param int $page
     * @return array
     */
    public function getAll($page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags', [
                'query' => [
                    'page' => $page
                ]
            ]);
        } catch (ClientException $e) {
            return [];
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents())->data :
            [];
    }

    /**
     * Find tag by ID
     * @param $tagId
     * @return array|mixed|null|object
     */
    public function findById($tagId)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/'.$tagId);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Find tags by brand ID
     * @param $brandId
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByBrandId($brandId, $page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/brand/'.$brandId, [
                'query' => [
                    'page' => $page
                ]
            ]);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Find the category from the Content Hub Id
     * @param $contenthubId
     * @return array|mixed|null|object
     */
    public function findByContentHubId($contenthubId)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/content-hub-id/'.$contenthubId);
        } catch (ClientException $e) {
            return null;
        }

        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
