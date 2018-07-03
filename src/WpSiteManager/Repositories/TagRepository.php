<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Contracts\TagContract;
use WpSiteManager\Http\SiteManagerClient;

/**
 * Class TagRepository
 * @package WpSiteManager\Repositories
 */
class TagRepository implements TagContract
{
    protected $siteManagerClient;

    function __construct()
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
     * @param $id
     * @return array|mixed|null|object
     */
    public function findById($id)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Find tags by brand ID
     * @param $id
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByBrandId($id, $page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/brand/'.$id, [
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
     * @param $id
     * @return array|mixed|null|object
     */
    public function findByContentHubId($id)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/tags/content-hub-id/'.$id);
        } catch (ClientException $e) {
            return null;
        }

        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }
}
