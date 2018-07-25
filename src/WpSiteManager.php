<?php

namespace Bonnier\WP\SiteManager;

use Bonnier\WP\SiteManager\Repositories\AppRepository;
use Bonnier\WP\SiteManager\Repositories\BrandRepository;
use Bonnier\WP\SiteManager\Repositories\CategoryRepository;
use Bonnier\WP\SiteManager\Repositories\SiteRepository;
use Bonnier\WP\SiteManager\Repositories\TagRepository;
use Bonnier\WP\SiteManager\Repositories\VocabularyRepository;
use Bonnier\WP\SiteManager\Services\AppService;
use Bonnier\WP\SiteManager\Services\BrandService;
use Bonnier\WP\SiteManager\Services\CategoryService;
use Bonnier\WP\SiteManager\Services\SiteService;
use Bonnier\WP\SiteManager\Services\TagService;
use Bonnier\WP\SiteManager\Services\VocabularyService;
use Bonnier\WP\SiteManager\Settings\SettingsPage;

class WpSiteManager
{
    /**
     * Text domain for translators
     */
    const TEXT_DOMAIN = 'wp-site-manager';
    const CLASS_DIR = 'src';

    /**
     * @var object Instance of this class.
     */
    private static $instance;

    private $settings;

    /** @var CategoryRepository */
    private $categoryService;

    /** @var AppRepository */
    private $appService;

    /** @var BrandRepository */
    private $brandService;

    /** @var SiteRepository */
    private $siteService;

    /** @var TagRepository */
    private $tagService;

    /** @var VocabularyRepository */
    private $vocabularyService;

    /** @var string Filename of this class. */
    public $file;

    /** @var string Basename of this class. */
    public $basename;

    /** @var string Plugins directory for this plugin. */
    public $pluginDir;

    /** @var Object */
    public $scripts;

    /** @var string Plugins url for this plugin. */
    public $pluginUrl;

    /**
     * Do not load this more than once.
     */
    private function __construct()
    {
        // Set plugin file variables
        $this->file = __FILE__;
        $this->basename = plugin_basename($this->file);
        $this->pluginDir = plugin_dir_path($this->file);
        $this->pluginUrl = plugin_dir_url($this->file);
        // Load textdomain
        load_plugin_textdomain(self::TEXT_DOMAIN, false, dirname($this->basename) . '/languages');

        $this->settings = new SettingsPage();

        $this->categoryService = new CategoryService(new CategoryRepository());
        $this->siteService = new SiteService(new SiteRepository());
        $this->tagService = new TagService(new TagRepository());
        $this->vocabularyService = new VocabularyService(new VocabularyRepository());
        $this->brandService = new BrandService(new BrandRepository());
        $this->appService = new AppService(new AppRepository());
    }

    /**
     * Returns the instance of this class.
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
            /**
             * Run after the plugin has been loaded.
             */
            do_action('wp_site_manager_loaded');
        }

        return self::$instance;
    }

    /**
     * @return CategoryRepository
     */
    public function categories()
    {
        return $this->categoryService;
    }

    /**
     * @return AppRepository
     */
    public function apps()
    {
        return $this->appService;
    }

    /**
     * @return BrandRepository
     */
    public function brands()
    {
        return $this->brandService;
    }

    /**
     * @return SiteRepository
     */
    public function sites()
    {
        return $this->siteService;
    }

    /**
     * @return TagRepository
     */
    public function tags()
    {
        return $this->tagService;
    }

    /**
     * @return VocabularyRepository
     */
    public function vocabularies()
    {
        return $this->vocabularyService;
    }

    public function settings()
    {
        return $this->settings;
    }
}
