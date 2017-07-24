<?php

namespace WpSiteManager\Services;

use WpSiteManager\Contracts\CategoryContract;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryContract $categoryRepository
     */
    function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = new $categoryRepository;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_all');
        if (false === $result) {
            $result = $this->categoryRepository->getAll();
            wp_cache_set('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_all', $result, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $result = wp_cache_get('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_'. $id);
        if (false === $result) {
            $result = $this->categoryRepository->findById($id);
            wp_cache_set('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_'. $id, $result, '', self::SITEMANAGER_CACHE_EXPIRE);
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
        $result = wp_cache_get('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_brand_'. $id .'_'. $page);
        if (false === $result) {
            $result = $this->categoryRepository->findByBrandId($id, $page);
            wp_cache_set('sm_'. self::SITEMANAGER_CATEGORY_CACHEKEY .'_brand_'. $id .'_'. $page, '', self::SITEMANAGER_CACHE_EXPIRE);
        }

        return $result;
    }
}