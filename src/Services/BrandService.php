<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Repositories\BrandRepository;

class BrandService extends BaseService
{
    protected $brandRepository;

    /**
     * SiteService constructor.
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey = sprintf('%s_all', self::SITEMANAGER_BRAND_CACHEKEY);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->brandRepository->getAll();
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $brandId
     * @return mixed
     */
    public function findById($brandId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_BRAND_CACHEKEY, $brandId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->brandRepository->findById($brandId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
