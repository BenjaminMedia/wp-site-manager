<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Http\SiteManagerClient;
use WpSiteManager\Contracts\VocabularyContract;

/**
 * Class VocabularyRepository
 * @package WpSiteManager\Repositories
 */
class VocabularyRepository implements VocabularyContract
{
    protected $siteManagerClient;

    function __construct()
    {
        $this->siteManagerClient = new SiteManagerClient();
    }

    /**
     * Get all vocabularies
     * @param int $page
     * @return array
     */
    public function getAll($page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/vocabularies', [
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
     * Get vocabulary by ID
     * @param $id
     * @return array|mixed|null|object
     */
    public function findById($id)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/vocabularies/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Get vocabulary from App ID
     * @param $id
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByAppId($id, $page=1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/vocabularies/app/'.$id, [
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
