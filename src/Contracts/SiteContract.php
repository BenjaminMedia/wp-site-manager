<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface SiteContract
{
    public function getAll();

    public function findById($siteSiteId);
}
