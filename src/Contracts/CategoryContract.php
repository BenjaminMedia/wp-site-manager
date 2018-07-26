<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface CategoryContract
{
    public function getAll();

    public function findById($categoryCategoryId);

    public function findByBrandId($brandBrandId, $page = 0);

    public function findByContentHubId($contenthubId);
}
