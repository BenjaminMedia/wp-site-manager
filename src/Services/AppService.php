<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Repositories\AppRepository;

class AppService extends BaseService
{
    protected $appRepository;

    /**
     * SiteService constructor.
     * @param AppRepository $appRepository
     */
    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey = sprintf('%s_all', self::SITEMANAGER_APP_CACHE);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->appRepository->getAll();
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $appId
     * @return mixed
     */
    public function findById($appId)
    {
        $cacheKey = sprintf('%s_%s', self::SITEMANAGER_APP_CACHE, $appId);
        $result = wp_cache_get($cacheKey, self::SITEMANAGER_CACHE_GROUP);
        if (false === $result) {
            $result = $this->appRepository->findById($appId);
            wp_cache_set($cacheKey, $result, self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}
