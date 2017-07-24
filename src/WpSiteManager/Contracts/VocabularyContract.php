<?php
namespace WpSiteManager\Contracts;

interface VocabularyContract {
    public function getAll($page = 1);
    public function findById($id);
    public function findByAppId($id, $page = 1);
}
