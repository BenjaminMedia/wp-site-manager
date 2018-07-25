<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface AppContract
{
    public function getAll();

    public function findById($appId);
}
