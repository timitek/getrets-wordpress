<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRETSSearchWidget
 *
 * @author josh
 */
class GetRETSSearchWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
                // Base ID of your widget
                'GetRETSSearchWidget',
                // Widget name will appear in UI
                __('GetRETS Search', 'GetRETSSearchWidget'),
                // Widget description
                ['description' => __('A widget to provide listing searches with advanced options.', 'GetRETSSearchWidget')]
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo GetRETSSearchShortcode::instance()->showSearch();

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form($instance) {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Search', 'GetRETSSearchWidget');
        }

        $template = new GetRETSTemplateEngine(GetRETSSettings::get('PLUGIN_DIR') . '/views/admin/searchWidget.php');
        $template->set('title', $title);
        $template->set('instance', $this);
        $content = $template->render();
        echo $content;
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
