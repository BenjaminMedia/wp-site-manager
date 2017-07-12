<?php

namespace WpSiteManager\Services;

use WpSiteManager\Http\SiteManagerClient;

class TagService
{
    protected $siteManagerClient;

    function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

    public function getAll($page)
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
}