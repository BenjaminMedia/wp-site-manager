<?php
namespace WpSiteManager\Contracts;

interface CategoryContract {
    public function getAll();
    public function findById($id);
    public function findByBrandId($id, $page = 0);
}
