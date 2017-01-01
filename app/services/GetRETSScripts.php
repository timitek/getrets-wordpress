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
class GetRETSScripts {
    
    private $scripts = [];
    private $styles = [];
    private $enqueued = false;
    
    public function __construct() {
    }
    
    private function handleEnque() {
        if ($this->enqueued === false) {
            $this->enqueued = true;
            add_action( 'wp_enqueue_scripts', [$this, 'enqueue'], 10 );
        }
    }
    
    public function addScript($src) {
        $handle = 'getrets_' . str_replace('.js', '', str_replace('/', '_', $src));
        $this->scripts[] = [
            'handle' => $handle,
            'src' => $src
        ];
        $this->handleEnque();
    }
    
    public function addStyle($src) {
        $handle = 'getrets_' . str_replace('.css', '', str_replace('/', '_', $src));
        $this->styles[] = [
            'handle' => $handle,
            'src' => $src
        ];
        $this->handleEnque();
    }
    
    public function enqueue() {
        $assetsUrl = GetRETSSettings::get('ASSETS_URL');
        $version = GetRETSSettings::get('VERSION');
        
        foreach($this->scripts as $item) {
            wp_register_script( $item['handle'], $assetsUrl . $item['src'], ['jquery'], $version );
            wp_enqueue_script( $item['handle'] );
        }
        
        foreach($this->styles as $item) {
            wp_register_style( $item['handle'], $assetsUrl . $item['src'], [], $version );
            wp_enqueue_style( $item['handle'] );
        }
    }
    
}
