<?php
namespace WpSiteManager\Contracts;

interface VocabularyContract {
    public static function getAll($page = 1);
    public static function findById($id);
    public static function findByAppId($id, $page = 1);
}
