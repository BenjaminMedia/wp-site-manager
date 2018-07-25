<?php

namespace Bonnier\WP\SiteManager\Repositories;

use Bonnier\WP\SiteManager\Http\SiteManagerClient;
use Bonnier\WP\SiteManager\Contracts\VocabularyContract;
use GuzzleHttp\Exception\ClientException;

/**
 * Class VocabularyRepository
 * @package Bonnier\WP\SiteManager\Repositories
 */
class VocabularyRepository implements VocabularyContract
{
    protected $siteManagerClient;

    public function __construct()
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
     * @param $vocabularyId
     * @return array|mixed|null|object
     */
    public function findById($vocabularyId)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/vocabularies/'.$vocabularyId);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    /**
     * Get vocabulary from App ID
     * @param $appId
     * @param int $page
     * @return array|mixed|null|object
     */
    public function findByAppId($appId, $page = 1)
    {
        try {
            $response = $this->siteManagerClient->get('/api/v1/vocabularies/app/'.$appId, [
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
