<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRETSSearchShortcode
 *
 * @author josh
 */
class GetRETSSearchShortcode {
    public static function instance () {
        static $_instance = null;
        
        if ($_instance === null) {
            $_instance = new GetRETSSearchShortcode();
        }
        
        return $_instance;
    }
    
    private function __construct() { 
        add_shortcode( 'getrets_search', [$this, 'showSearch'] );

        $s = new GetRETSScripts();
        $s->addScript('js/search.js');
        $s->addStyle('css/search.css'); 
    }
    
    public function showSearch($attributes = null) {
        $template = new GetRETSTemplateEngine(GetRETSSettings::get('PLUGIN_DIR') . '/views/frontend/search.php');
        $template->set('attributes', $attributes);
        $content = $template->render();
        return $content;
    }    
}
