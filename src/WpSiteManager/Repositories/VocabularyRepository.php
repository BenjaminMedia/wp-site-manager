<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Contracts\VocabularyContract;
use WpSiteManager\Services\SiteManagerService;
use GuzzleHttp\Exception\ClientException;


class VocabularyRepository implements VocabularyContract
{

    public static function getAll($page = 1)
    {
        try {
            $response = SiteManagerService::getInstance()->get('/api/v1/vocabularies', [
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

    public static function findById($id)
    {
        try {
            $response = SiteManagerService::getInstance()->get('/api/v1/vocabularies/'.$id);
        } catch (ClientException $e) {
            return null;
        }
        return $response->getStatusCode() === 200 ?
            json_decode($response->getBody()->getContents()) :
            null;
    }

    public static function findByAppId($id, $page = 1)
    {
        try {
            $response = SiteManagerService::getInstance()->get('/api/v1/vocabularies/app/'.$id, [
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
