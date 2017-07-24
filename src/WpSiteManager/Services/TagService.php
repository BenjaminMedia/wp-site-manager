<?php

namespace WpSiteManager\Services;

use WpSiteManager\Contracts\TagContract;

class TagService extends BaseService
{
    protected $tagRepository;

    /**
     * TagService constructor.
     * @param TagContract $tagRepository
     */
    function __construct(TagContract $tagRepository)
    {
        $this->tagRepository = new $tagRepository;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function getAll($page)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_all_'.$page);
        if (false === $result) {
            $result = $this->tagRepository->getAll($page);
            wp_cache_set('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_all_'.$page, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_'.$id);
        if (false === $result) {
            $result = $this->tagRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_'.$id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function findByBrandId($id, $page = 1)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_brand_'.$id.'_'.$page);
        if (false === $result) {
            $result = $this->tagRepository->findByBrandId($id, $page);
            wp_cache_set('sm_'. self::SITEMANAGER_TAG_CACHEKEY .'_brand_'.$id.'_'.$page, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}