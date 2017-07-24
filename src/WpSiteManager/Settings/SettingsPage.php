<?php

namespace WpSiteManager\Settings;

use PLL_Language;
use WpSiteManager\Repositories\SiteRepository;
use WpSiteManager\Services\SiteService;

class SettingsPage
{
    private $siteService;

    const SETTINGS_KEY = 'bp_sm_settings';
    const SETTINGS_GROUP = 'bp_sm_settings_group';
    const SETTINGS_SECTION = 'bp_sm_settings_section';
    const SETTINGS_PAGE = 'bp_sm_settings_page';
    const NOTICE_PREFIX = 'Site Manager:';
    const SETTINGS_TOOLBAR_NAME = 'Site Manager';
    const SETTING_SITE = 'sitemanger';

    private $settingsFields = [
        'site' => [
            'type' => 'select',
            'name' => 'Site',
            'options_callback' => [__CLASS__, 'siteManagerGetSites']
        ],
    ];

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $settingsValues;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->siteService = new SiteService(new SiteRepository());
        $this->settingsValues = get_option(self::SETTINGS_KEY);
        //dd(get_option(self::SETTINGS_KEY));
        add_action('admin_menu', [$this, 'addPluginPage']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    function printError($error)
    {
        $out = "<div class='error settings-error notice is-dismissible'>";
        $out .= "<strong>" . self::NOTICE_PREFIX . "</strong><p>$error</p>";
        $out .= "</div>";
        print $out;
    }

    /**
     * Add options page
     */
    public function addPluginPage()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            self::SETTINGS_TOOLBAR_NAME,
            'manage_options',
            self::SETTINGS_PAGE,
            [$this, 'createAdminPage']
        );
    }

    /**
     * Options page callback
     */
    public function createAdminPage()
    {
        // Set class property

        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields(self::SETTINGS_GROUP);
                do_settings_sections(self::SETTINGS_PAGE);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function registerSettings()
    {
        if ($this->languagesIsEnabled()) {
            $this->enableLanguageFields();
        }

        register_setting(
            self::SETTINGS_GROUP, // Option group
            self::SETTINGS_KEY, // Option name
            [$this, 'sanitize'] // Sanitize
        );

        add_settings_section(
            self::SETTINGS_SECTION, // ID
            'Site Manger Settings', // Title
            [$this, 'printSectionInfo'], // Callback
            self::SETTINGS_PAGE // Page
        );

        foreach ($this->settingsFields as $settingsKey => $settingField) {
            add_settings_field(
                $settingsKey, // ID
                $settingField['name'], // Title
                [$this, $settingsKey], // Callback
                self::SETTINGS_PAGE, // Page
                self::SETTINGS_SECTION // Section
            );
        }
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     * @return array
     */
    public function sanitize($input)
    {
        $sanitizedInput = [];

        foreach ($this->settingsFields as $fieldKey => $settingsField) {
            if (isset($input[$fieldKey])) {
                if ($settingsField['type'] === 'checkbox') {
                    $sanitizedInput[$fieldKey] = absint($input[$fieldKey]);
                }
                if ($settingsField['type'] === 'text' || $settingsField['type'] === 'select') {
                    $sanitizedInput[$fieldKey] = sanitize_text_field($input[$fieldKey]);
                }
            }
        }

        return $sanitizedInput;
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        print 'Enter your settings below:';
    }

    /**
     * Catch callbacks for creating setting fields
     * @param string $function
     * @param array $arguments
     * @return bool
     */
    public function __call($function, $arguments)
    {
        if (!isset($this->settingsFields[$function])) {
            return false;
        }

        $field = $this->settingsFields[$function];
        $this->createSettingsField($field, $function);

    }

    public function getSettingValue($settingKey, $locale = null)
    {
        if(!$this->settingsValues) {
            $this->settingsValues = get_option(self::SETTINGS_KEY);
        }

        if ($locale) {
            $settingKey = $locale . '_' . $settingKey;
        }

        if (isset($this->settingsValues[$settingKey]) && !empty($this->settingsValues[$settingKey])) {
            return $this->settingsValues[$settingKey];
        }
        return null;
    }

    public function getSiteId($locale = null)
    {
        return $this->getSettingValue(static::SETTING_SITE, $locale);
    }

    public function getSite($locale = null)
    {
        return $this->siteService->findById($this->getSiteId($locale));
    }

    private function siteManagerGetSites($locale) {
        return collect($this->siteService->getAll())->map(function($site){
           return [
               'label' => $site->domain,
               'value' => $site->id
           ];
        });
    }

    private function enableLanguageFields()
    {
        $languageEnabledFields = [];

        foreach ($this->getLanguages() as $language) {
            foreach ($this->settingsFields as $fieldKey => $settingsField) {

                $localeFieldKey = $language->locale . '_' . $fieldKey;
                $languageEnabledFields[$localeFieldKey] = $settingsField;
                $languageEnabledFields[$localeFieldKey]['name'] .= ' ' . $language->locale;
                $languageEnabledFields[$localeFieldKey]['locale'] = $language->locale;

            }
        }

        $this->settingsFields = $languageEnabledFields;

    }

    public function languagesIsEnabled()
    {
        return function_exists('Pll') && PLL()->model->get_languages_list();
    }

    public function getLanguages()
    {
        if ($this->languagesIsEnabled()) {
            return PLL()->model->get_languages_list();
        }
        return false;
    }

    /**
     * Get the current language by looking at the current HTTP_HOST
     *
     * @return null|PLL_Language
     */
    public function getCurrentLanguage()
    {
        if ($this->languagesIsEnabled()) {
            return PLL()->model->get_language(pll_current_language());
        }
        return null;
    }

    public function getCurrentLocale() {
        $currentLang = $this->getCurrentLanguage();
        return $currentLang ? $currentLang->locale : null;
    }

    private function getSelectFieldOptions($field)
    {
        if (isset($field['options_callback'])) {
            $options = call_user_func($field['options_callback'], $field['locale']);
            if ($options) {
                return $options;
            }
        }

        return [];

    }

    private function createSettingsField($field, $fieldKey)
    {
        $fieldName = self::SETTINGS_KEY . "[$fieldKey]";
        $fieldOutput = false;

        if ($field['type'] === 'text') {
            $fieldValue = isset($this->settingsValues[$fieldKey]) ? esc_attr($this->settingsValues[$fieldKey]) : '';
            $fieldOutput = "<input type='text' name='$fieldName' value='$fieldValue' class='regular-text' />";
        }
        if ($field['type'] === 'checkbox') {
            $checked = isset($this->settingsValues[$fieldKey]) && $this->settingsValues[$fieldKey] ? 'checked' : '';
            $fieldOutput = "<input type='hidden' value='0' name='$fieldName'>";
            $fieldOutput .= "<input type='checkbox' value='1' name='$fieldName' $checked />";
        }
        if ($field['type'] === 'select') {
            $fieldValue = isset($this->settingsValues[$fieldKey]) ? $this->settingsValues[$fieldKey] : '';
            $fieldOutput = "<select name='$fieldName'>";
            $options = $this->getSelectFieldOptions($field);
            foreach ($options as $option) {
                $selected = ($option['value'] == $fieldValue) ? 'selected' : '';
                $fieldOutput .= "<option value='" . $option['value'] . "' $selected >" . $option['label'] . "</option>";
            }
            $fieldOutput .= "</select>";
        }

        if ($fieldOutput) {
            print $fieldOutput;
        }
    }

}
