<?php

namespace WpSiteManager\Repositories;

use WpSiteManager\Services\TagService;
use WpSiteManager\Contracts\TagContract;

class TagRepository implements TagContract
{
    protected $tagService;

    function __construct()
    {
        $this->tagService = new TagService();
    }

    public function getAll($page = 1)
    {
       $this->tagService->getAll($page);
    }

    public function findById($id)
    {
       $this->tagService->findById($id);
    }

    public function findByBrandId($id, $page = 1)
    {
        $this->tagService->findByBrandId($id, $page);
    }
}
