<?php

namespace Bonnier\WP\SiteManager\Services;

use Bonnier\WP\SiteManager\Contracts\SiteContract;
use Bonnier\WP\SiteManager\Exceptions\SiteNotFoundException;

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
     *
     * @return mixed
     * @throws \Bonnier\WP\SiteManager\Exceptions\SiteNotFoundException
     */
    public function findById($siteId)
    {
        $cacheKey = sprintf('%s_%s_%s', self::SITEMANAGER_CACHE_GROUP, self::SITEMANAGER_SITE_CACHEKEY, $siteId);
        $result = get_transient($cacheKey);
        if (false === $result || $this->shouldUpdateCache($result)) {
            if ($site = $this->siteRepository->findById($siteId)) {
                $result = [
                    'data' => $site,
                    'timestamp' => time()
                ];
                set_transient($cacheKey, $result);
            } elseif (false === $result) {
                throw new SiteNotFoundException(sprintf('Failed fetching site by id: %s', $siteId));
            }
        }
        return $result['data'];
    }

    private function shouldUpdateCache($cacheResponse)
    {
        return (time() - $cacheResponse['timestamp'] ?? time()) > self::SITEMANAGER_CACHE_EXPIRE;
    }
}
