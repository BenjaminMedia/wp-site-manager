<?php

namespace WpSiteManager\Services;

use WpSiteManager\Contracts\SiteContract;

class SiteService extends BaseService
{
    protected $siteRepository;

    /**
     * SiteService constructor.
     * @param SiteContract $siteRepository
     */
    function __construct(SiteContract $siteRepository)
    {
        $this->siteRepository = new $siteRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_SITE_CACHEKEY .'_all');
        if (false === $result) {
            $result = $this->siteRepository->getAll();
            wp_cache_set('sm_'. self::SITEMANAGER_SITE_CACHEKEY .'_all', $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_SITE_CACHEKEY .'_'. $id);
        if (false === $result) {
            $result = $this->siteRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_SITE_CACHEKEY .'_' . $id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}