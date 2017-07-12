<?php

namespace WpSiteManager\Services;

use WpSiteManager\Http\SiteManagerClient;

class SiteService
{
    protected $siteManagerClient;

    function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

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