<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface TagContract
{
    public function getAll($page = 1);

    public function findById($tagTagId);

    public function findByBrandId($brandBrandId, $page = 1);

    public function findByContentHubId($contenthubId);
}
