<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface BrandContract
{
    public function getAll();

    public function findById($brandBrandId);
}
