<?php

namespace WpSiteManager\Services;

use WpSiteManager\Repositories\BrandRepository;

class BrandService extends BaseService
{
    protected $brandRepository;

    /**
     * SiteService constructor.
     * @param BrandRepository $BrandRepository
     */
    function __construct(BrandRepository $BrandRepository)
    {
        $this->brandRepository = new $BrandRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_BRAND_CACHEKEY .'_all');
        if (false === $result) {
            $result = $this->brandRepository->getAll();
            wp_cache_set('sm_'. self::SITEMANAGER_BRAND_CACHEKEY .'_all', $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_BRAND_CACHEKEY .'_'. $id);
        if (false === $result) {
            $result = $this->brandRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_BRAND_CACHEKEY .'_' . $id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}