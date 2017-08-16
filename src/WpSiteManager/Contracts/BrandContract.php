<?php
namespace WpSiteManager\Contracts;

interface BrandContract {
    public function getAll();
    public function findById($id);
}
