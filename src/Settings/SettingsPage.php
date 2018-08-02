<?php

namespace Bonnier\WP\SiteManager\Settings;

use Bonnier\Willow\MuPlugins\Helpers\AbstractSettingsPage;
use Bonnier\WP\SiteManager\Repositories\SiteRepository;
use Bonnier\WP\SiteManager\Services\SiteService;

class SettingsPage extends AbstractSettingsPage
{
    private $siteService;

    protected $settingsKey = 'bp_sm_settings';
    protected $settingsGroup = 'bp_sm_settings_group';
    protected $settingsSection = 'bp_sm_settings_section';
    protected $settingsPage = 'bp_sm_settings_page';
    protected $noticePrefix = 'Site Manager:';
    protected $toolbarName = 'Site Manager';
    protected $site = 'sitemanager';
    protected $title = 'Site Manager';

    protected $settingsFields = [
        'sitemanager' => [
            'type' => 'select',
            'name' => 'Site',
            'options_callback' => 'siteManagerGetSites'
        ],
    ];


    public function __construct()
    {
        $this->siteService = new SiteService(new SiteRepository());
        parent::__construct();
    }

    public function getSiteId($locale = null)
    {
        return $this->getSettingValue($this->site, $locale);
    }

    public function getSite($locale = null)
    {
        return $this->siteService->findById($this->getSiteId($locale));
    }

    public function siteManagerGetSites($locale)
    {
        return collect($this->siteService->getAll())->map(function ($site) {
            return [
               'label' => $site->domain,
               'value' => $site->id
            ];
        });
    }
}
