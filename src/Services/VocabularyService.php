<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Contracts\VocabularyContract;

class VocabularyService extends BaseService
{
    protected $vocabularyRepository;

    /**
     * VocabularyService constructor.
     * @param VocabularyContract $vocabularyRepository
     */
    public function __construct(VocabularyContract $vocabularyRepository)
    {
        $this->vocabularyRepository = $vocabularyRepository;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function getAll($page)
    {
        $cacheKey = sprintf('%s_all_%s', self::SITEMANAGER_VOCABULARY_CACHEKEY, $page);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->vocabularyRepository->getAll($page);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $vocabularyId
     * @return mixed
     */
    public function findById($vocabularyId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_VOCABULARY_CACHEKEY, $vocabularyId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->vocabularyRepository->findById($vocabularyId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $appId
     * @param int $page
     * @return mixed
     */
    public function findByAppId($appId, $page = 1)
    {
        $cacheKey = sprintf('%s_app_%s_%s', self::SITEMANAGER_VOCABULARY_CACHEKEY, $appId, $page);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->vocabularyRepository->findByAppId($appId, $page);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
