<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Contracts\SiteContract;

class SiteService extends BaseService
{
    protected $siteRepository;

    /**
     * SiteService constructor.
     * @param SiteContract $siteRepository
     */
    public function __construct(SiteContract $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey = sprintf('%s_all', self::SITEMANAGER_SITE_CACHEKEY);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->siteRepository->getAll();
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $siteId
     * @return mixed
     */
    public function findById($siteId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_SITE_CACHEKEY, $siteId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->siteRepository->findById($siteId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
