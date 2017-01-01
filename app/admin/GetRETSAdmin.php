<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRETSAdmin
 *
 * @author josh
 */
class GetRETSAdmin {
    
    public static function instance () {
        static $_instance = null;
        
        if ($_instance === null) {
            $_instance = new GetRETSAdmin();
        }
        
        return $_instance;
    }

    private function __construct() { 
        register_activation_hook( GetRETSSettings::get('PLUGIN_DIR') . 'getrets.php', [ $this, 'activate' ] );

        if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
            add_action( 'admin_menu', [ $this, 'createAdminMenu' ] );
            add_action( 'admin_init', [ $this, 'initializeAdmin' ] );
        }
    }

    public function activate() {
        if (version_compare($GLOBALS['wp_version'], GetRETSSettings::get('MIN_WP_VERSION'), '<')) {
            $message = sprintf('GetRETS %s requires WordPress %s or higher.', GetRETSSettings::get('VERSION'), GetRETSSettings::get('MIN_WP_VERSION'));
            $this->failActivation($message);
        }
        else {
            GetRETSSettings::initializeSettings();
        }
    }
    
    public function createAdminMenu() {
        $settingsPage =
        add_options_page( 'GetRETS Settings', 
                          'GetRETS', 
                          'manage_options', 
                          'getrets-admin-settings', 
                          [$this, 'settingsPage'] );
        
        if ( $settingsPage ) {
            add_action( 'load-' . $settingsPage, [$this, 'settingsPageHelp'] );
        }
    }
    
    public function initializeAdmin() {
        add_action( 'admin_post_getrets_save_settings', [$this, 'saveSettings'] );
    }
    
    public function settingsPage() {
        include GetRETSSettings::get('PLUGIN_DIR') . 'views/admin/settings.php';
    }
    
    public function settingsPageHelp() {
        $screen = get_current_screen();
        $screen->add_help_tab([
            'id' => 'getrets-admin-help-instructions',
            'title' => 'Instructions',
            'callback' => [$this, 'showInstructions']
        ]);
        $screen->set_help_sidebar('<p><strong>' . __('For more information:') . '</strong></p>' .
                '<p>' . __('See <a href="http://www.timitek.com/" target="_blank">www.timitek.com</a>') . '</p>' .
                '<p>' . __('Swagger documentation can be found at <a href="http://getrets.net/swagger" target="_blank">getrets.net/swagger</a>') . '</p>'
        );
    } 
    
    public function showInstructions() {
        include GetRETSSettings::get('PLUGIN_DIR') . 'views/admin/instructions.php';
    }
    
    public function saveSettings() {
        // Check that user has proper security level
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( 'Not allowed' );
        }

        // Check that nonce field created in configuration form is present
        check_admin_referer( 'getrets_settings' );
        
        if ( isset( $_POST['getrets_customer_key'] ) ) {
            GetRETSSettings::setOption('CUSTOMER_KEY', sanitize_text_field( $_POST["getrets_customer_key"]));
        }
        
        GetRETSSettings::setOption('DISABLE_CACHE', isset($_POST["getrets_disable_cache"]));

        GetRETSSettings::setOption('SHOW_THUMBNAIL', isset($_POST["getrets_show_thumbnail"]));        
        
        wp_redirect( add_query_arg( ['page' => 'getrets-admin-settings', 'message' => '1'], admin_url( 'options-general.php' ) ) );
        
        exit;
    }
    

    private function failActivation($message, $deactivate = true) {
        echo esc_html($message);
        
        if ($deactivate) {
            $plugins = get_option('active_plugins');
            $getrets = plugin_basename(GetRETSSettings::get('PLUGIN_DIR') . 'getrets.php');
            $update = false;
            foreach ($plugins as $i => $plugin) {
                if ($plugin === $getrets) {
                    $plugins[$i] = false;
                    $update = true;
                }
            }

            if ($update) {
                update_option('active_plugins', array_filter($plugins));
            }
        }
        exit;
    }

}
