<?php

namespace WpSiteManager\Services;

use WpSiteManager\Repositories\AppRepository;

class AppService extends BaseService
{
    protected $AppRepository;

    /**
     * SiteService constructor.
     * @param AppRepository $AppRepository
     */
    function __construct(AppRepository $AppRepository)
    {
        $this->AppRepository = new $AppRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_APP_CACHE .'_all');
        if (false === $result) {
            $result = $this->AppRepository->getAll();
            wp_cache_set('sm_'. self::SITEMANAGER_APP_CACHE .'_all', $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_APP_CACHE .'_'. $id);
        if (false === $result) {
            $result = $this->AppRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_APP_CACHE .'_' . $id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}