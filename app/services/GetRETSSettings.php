<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getrets_settings
 *
 * @author josh
 */
final class GetRETSSettings {
    
    // This has to be a public static instead of a const because it's an array in order to support older versions of PHP
    public static $DEFAULT_OPTIONS = [
        "CUSTOMER_KEY" => "",
        "DISABLE_CACHE" => false,
        "SHOW_THUMBNAIL" => true
    ];

    private $settings;
    
    private function __construct() {
        $this->settings = [
            'VERSION' => '1.0.0',
            'PLUGIN_DIR' => GETRETS_PLUGIN_DIR, //plugin_dir_path(__FILE__) . '../../',
            'ASSETS_URL' => esc_url( trailingslashit( plugins_url( 'assets', GETRETS_PLUGIN_DIR . '/assets/') ) ),
            'MIN_WP_VERSION' => '4.0'
        ];
    }

    public static function instance () {
        static $_instance = null;
        
        if ($_instance === null) {
            $_instance = new GetRETSSettings();
        }
        
        return $_instance;
    }
    
    public static function get($key) {
        $value = null;
        if (array_key_exists($key, GetRETSSettings::instance()->settings)) {
            $value = GetRETSSettings::instance()->settings[$key];
        }
        return $value;
    }
    
    public static function initializeSettings() {
        $version = get_option("GetRETS_version");

        // Version 1.0.0
        if ($version === false) {
            add_option("GetRETS_version", GetRETSSettings::get('VERSION'));
            add_option("GetRETS_options", GetRETSSettings::$DEFAULT_OPTIONS);
        }
    }
    
    public static function getOption($key) {
        $defaults = GetRETSSettings::$DEFAULT_OPTIONS;
        $value = $defaults[$key];
        
        $options = GetRETSSettings::get("OPTIONS");
        if (empty($options)) {
            $options = get_option("GetRETS_options");
            if (empty($options)) {
                $options = $defaults;
            }
            GetRETSSettings::instance()->settings["OPTIONS"] = $options;
        }
        
        if (!empty($options)) {
            if (array_key_exists($key, $options)) {
                $value = $options[$key];
            }
        }
        
        return $value;
    }
    
    public static function setOption($key, $value) {
        // Force options to load
        $previous = GetRETSSettings::getOption($key);
        if ($previous != $value) {
            $options = GetRETSSettings::get("OPTIONS");
            $options[$key] = $value;
            GetRETSSettings::instance()->settings["OPTIONS"] = $options;
            update_option("GetRETS_options", $options);
        }
    }
}
