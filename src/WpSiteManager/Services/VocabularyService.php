<?php

namespace WpSiteManager\Services;

use WpSiteManager\Contracts\VocabularyContract;

class VocabularyService extends BaseService
{
    protected $vocabularyRepository;

    /**
     * VocabularyService constructor.
     * @param VocabularyContract $vocabularyRepository
     */
    function __construct(VocabularyContract $vocabularyRepository)
    {
        $this->vocabularyRepository = new $vocabularyRepository;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function getAll($page)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_all_'.$page);
        if (false === $result) {
            $result = $this->vocabularyRepository->getAll($page);
            wp_cache_set('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_all_'.$page, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_'.$id);
        if (false === $result) {
            $result = $this->vocabularyRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_'.$id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function findByAppId($id, $page = 1)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_app_'.$id.'_'.$page);
        if (false === $result) {
            $result = $this->vocabularyRepository->findByAppId($id, $page);
            wp_cache_set('sm_'. self::SITEMANAGER_VOCABULARY_CACHEKEY .'_app_'.$id.'_'.$page, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}