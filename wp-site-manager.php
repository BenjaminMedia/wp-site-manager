<?php
/**
 * Plugin Name: WP Site Manager
 * Plugin URI: http://bonnierpublications.com
 * Description: Service for the site manager
 * Version: 0.0.1
 * Author: Michael Sørensen
 * Author URI: http://bonnierpublications.com
 */

namespace WpSiteManager;

// Do not access this file directly
use WpSiteManager\Repositories\CategoryRepository;
use WpSiteManager\Repositories\SiteRepository;
use WpSiteManager\Repositories\TagRepository;
use WpSiteManager\Repositories\VocabularyRepository;
use WpSiteManager\Services\CategoryService;
use WpSiteManager\Services\SiteService;
use WpSiteManager\Services\TagService;
use WpSiteManager\Services\VocabularyService;

if (!defined('ABSPATH')) {
    exit;
}

// Handle autoload so we can use namespaces
spl_autoload_register(function ($className) {

    if (strpos($className, __NAMESPACE__) !== false) {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
        //require_once(__DIR__ . DIRECTORY_SEPARATOR . $className . '.php');
        require_once(__DIR__ . DIRECTORY_SEPARATOR . Plugin::CLASS_DIR . DIRECTORY_SEPARATOR . $className . '.php');
    }
});

// Load plugin api
require_once (__DIR__ . '/'.Plugin::CLASS_DIR.'/Api.php');

class Plugin
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

    /**
     * @var CategoryRepository
     */
    private $categoryService;

    /**
     * @var SiteRepository
     */
    private $siteService;

    /**
     * @var TagRepository
     */
    private $tagService;

    /**
     * @var VocabularyRepository
     */
    private $vocabularyService;

    /**
     * @var string Filename of this class.
     */
    public $file;

    /**
     * @var string Basename of this class.
     */
    public $basename;

    /**
     * @var string Plugins directory for this plugin.
     */
    public $pluginDir;

    /**
     * @var Object
     */
    public $scripts;

    /**
     * @var string Plugins url for this plugin.
     */
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

        $this->categoryService = new CategoryService(new CategoryRepository());
        $this->siteService = new SiteService(new SiteRepository());
        $this->tagService = new TagService(new TagRepository());
        $this->vocabularyService = new VocabularyService(new VocabularyRepository());
    }

    /**
     * Returns the instance of this class.
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
            global $wpSiteManager;
            $wpSiteManager = self::$instance;

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
}

/**
 * @return Plugin $instance returns an instance of the plugin
 */
function instance()
{
    return Plugin::instance();
}

add_action('plugins_loaded', __NAMESPACE__ . '\instance', 0);