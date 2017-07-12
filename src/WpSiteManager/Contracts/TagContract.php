<?php
namespace WpSiteManager\Contracts;

interface TagContract {
    public function getAll($page = 1);
    public function findById($id);
    public function findByBrandId($id, $page = 1);
}
