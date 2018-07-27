<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use Bonnier\WP\SiteManager\Contracts\CategoryContract;
use GuzzleHttp\Exception\ClientException;

/**
 * Class CategoryRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class CategoryRepository implements CategoryContract
{
    protected $siteManagerClient;

    /**
     * CategoryRepository constructor.
     */
    public function __construct()
    {
        $this->siteManagerClient = SiteManagerClient::getInstance();
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
     * @param $categoryId
     * @return array|mixed|null|object
     */
    public function findById($categoryId)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/categories/' . $categoryId);
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
            $response = $this->siteManagerClient->get('/api/v1/categories/content-hub-id/'.$contenthubId);
        } catch (ClientException $e) {
            return null;
        }

        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Find all categories by brand id
     * @param $brandId
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByBrandId($brandId, $page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/categories/brand/' . $brandId, [
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
