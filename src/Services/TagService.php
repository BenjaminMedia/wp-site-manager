<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Contracts\TagContract;

class TagService extends BaseService
{
    protected $tagRepository;

    /**
     * TagService constructor.
     * @param TagContract $tagRepository
     */
    public function __construct(TagContract $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function getAll($page)
    {
        $cacheKey = sprintf('%s_all_%s', self::SITEMANAGER_TAG_CACHEKEY, $page);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->tagRepository->getAll($page);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $tagId
     * @return mixed
     */
    public function findById($tagId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_TAG_CACHEKEY, $tagId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->tagRepository->findById($tagId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $brandId
     * @param int $page
     * @return mixed
     */
    public function findByBrandId($brandId, $page = 1)
    {
        $cacheKey = sprintf('%s_brand_%s_%s', self::SITEMANAGER_TAG_CACHEKEY, $brandId, $page);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->tagRepository->findByBrandId($brandId, $page);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $contenthubId
     * @return mixed
     */
    public function findByContentHubId($contenthubId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_TAG_CACHEKEY, $contenthubId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->tagRepository->findByContentHubId($contenthubId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
