<?php

namespace WpSiteManager\Services;

abstract class BaseService
{
    // Cache expire time (in sec)
    const SITEMANAGER_CACHE_EXPIRE = "1800";
    // Cache keys
    const SITEMANAGER_VOCABULARY_CACHEKEY = "voca";
    const SITEMANAGER_TAG_CACHEKEY = "tag";
    const SITEMANAGER_SITE_CACHEKEY = "site";
    const SITEMANAGER_CATEGORY_CACHEKEY = "cat";
    const SITEMANAGER_BRAND_CACHEKEY = 'brand';
    const SITEMANAGER_APP_CACHE = 'app';
}