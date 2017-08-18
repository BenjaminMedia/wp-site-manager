<?php
namespace WpSiteManager\Contracts;

interface AppContract {
    public function getAll();
    public function findById($id);
}
