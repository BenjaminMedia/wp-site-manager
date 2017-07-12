<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Services\SiteService;
use WpSiteManager\Contracts\SiteContract;

class SiteRepository implements SiteContract
{
    protected $siteService;

    function __construct()
    {
        $this->siteService = new SiteService();
    }

    public function getAll()
    {
       return $this->siteService->getAll();
    }

    public function findById($id)
    {
        return $this->siteService->findById($id);
    }
}
