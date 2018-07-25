<?php
namespace Bonnier\WP\SiteManager\Contracts;

interface VocabularyContract
{
    public function getAll($page = 1);

    public function findById($vocabularyVocabularyId);

    public function findByAppId($appAppId, $page = 1);
}
