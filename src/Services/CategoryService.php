<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Contracts\CategoryContract;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryContract $categoryRepository
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey = sprintf('%s_all', self::SITEMANAGER_CATEGORY_CACHEKEY);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->categoryRepository->getAll();
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function findById($categoryId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_CATEGORY_CACHEKEY, $categoryId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->categoryRepository->findById($categoryId);
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
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_CATEGORY_CACHEKEY, $contenthubId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->categoryRepository->findByContentHubId($contenthubId);
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
        $cacheKey = sprintf('%s_brand_%s_%s', self::SITEMANAGER_CATEGORY_CACHEKEY, $brandId, $page);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->categoryRepository->findByBrandId($brandId, $page);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
