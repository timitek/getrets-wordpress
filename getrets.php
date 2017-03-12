<?php

/*
  Plugin Name: GetRETS
  Plugin URI: www.timitek.com
  Description: Instantly add real estate listing data to your website.  Allows listings, from multiple feeds, to appear within your site as native content.
  Version: 1.0.4
  Author: www.timitek.com
  Author URI: http://www.timitek.com
  License: GPLv2
 */

/*
  Copyright (C) 2016 timitek

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of2
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define( 'GETRETS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETSSettings.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETSScripts.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETSSearch.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETSPost.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETSTemplateEngine.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/services/GetRETS.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/admin/GetRETSAdmin.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/widgets/GetRETSSearchWidget.php' );
require_once( GETRETS_PLUGIN_DIR . 'app/shortcodes/GetRETSSearchShortcode.php' );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    GetRETSAdmin::instance();
}

if ( !is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    GetRETSSearchShortcode::instance();
    GetRETSSearch::instance();
}
    
function registerWidgets() {
    register_widget('GetRETSSearchWidget');
}
add_action('widgets_init', 'registerWidgets');

?>