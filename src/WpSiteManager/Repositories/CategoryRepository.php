<?php

namespace wpSiteManager\Repositories;

use wpSiteManager\Http\SiteManagerClient;
use wpSiteManager\Contracts\CategoryContract;

/**
 * Class CategoryRepository
 * @package WpSiteManager\Repositories
 */
class CategoryRepository implements CategoryContract
{
    protected $siteManagerClient;

    /**
     * CategoryRepository constructor.
     */
    function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

    /**
     * Get all the categories
     * @return array
     */
    public function getAll()
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/categories');
        } catch (ClientException $e) {
            return [];
        }

        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents())->data :
            [];
    }

    /**
     * Find the category from the ID
     * @param $id
     * @return array|mixed|null|object
     */
    public function findById($id)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/categories/'.$id);
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
            $response = $this->siteManagerClient->get('/api/v1/categories/content-hub-id/'.$id);
        } catch (ClientException $e) {
            return null;
        }

        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Find all categories by brand id
     * @param $id
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByBrandId($id, $page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/categories/brand/' . $id, [
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
}
