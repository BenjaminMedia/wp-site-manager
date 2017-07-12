<?php
namespace WpSiteManager\Contracts;

interface SiteContract {
    public function getAll();
    public function findById($id);
}
