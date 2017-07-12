<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Contracts\CategoryContract;
use WpSiteManager\Services\CategoryService;
use WpSiteManager\Services\SiteManagerService;
use GuzzleHttp\Exception\ClientException;

class CategoryRepository implements CategoryContract
{
    protected $categoryService;

    function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function getAll()
    {
        return $this->categoryService->getAll();
    }

    public function findById($id)
    {
        return $this->categoryService->findById($id);
    }

    public function findByBrandId($id)
    {
        return $this->categoryService->findByBrandId($id);
    }

    /*private $siteManagerService;

    function __construct()
    {
        $this->siteManagerService = new SiteManagerService();
    }

    public function getAll()
    {
        try {
            $response = $this->siteManagerService->get('/api/v1/categories');
        } catch (ClientException $e) {
            return [];
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents())->data :
            [];
    }

    public function findById($id)
    {
        try {
            $response = SiteManagerService::getInstance()->get('/api/v1/categories/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    public function findByBrandId($id, $page = 1)
    {
        try {
            $response = SiteManagerService::getInstance()->get('/api/v1/categories/brand/' . $id, [
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
    }*/
}
