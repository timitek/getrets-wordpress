<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRETSSearch
 *
 * @author josh
 */
class GetRETSSearch {

    const POST_TYPE = 'getrets_listing';
    
    private $getRETS = null;
    
    private $searchClient = null;

    private $query = null;
    
    private $parameters = [];
    
    private $listingPosts = null;
    
    private $getRETSPostType = [
        'labels' => [
            'name' => 'Listings',
            'singular_name' => 'Listing',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Listing',
            'edit' => 'Edit',
            'edit_item' => 'Edit Listing',
            'new_item' => 'New Listing',
            'view' => 'View',
            'view_item' => 'View Listing',
            'search_items' => 'Search Listings',
            'not_found' => 'No listings found',
            'not_found_in_trash' => 'No listings found in trash',
            'parent' => 'Parent Listing',
            'parent_item_colon' => 'Parent Listing',
            'all_items' => 'All Listings',
            'archives' => 'Listing Archives',
            'insert_item_into' => 'Insert into listing',
            'uploaded_to_this_item' => 'Uploaded to this listing',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'menu_name' => 'GetRETS Listings',
            //'filter_items_list' => 'hidden heading',
            //'items_list_navigation' => 'Pagination hidden heading',
            //'items_list' => 'Hidden heading',
            'name_admin_bar' => 'Listing'
        ],
        'description' => 'Listings retrieved from the MLS',
        'public' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        'show_in_menu' => false,
        'show_in_admin_bar' => false,
        'menu_position' => 20,
        'menu_icon' => null,
        //'capability_type' => 'listing',
        //'capabilities' => 
        'map_meta_cap' => null,
        'hierarchical' => false,
        'supports' => [
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            //'trackbacks',
            'custom-fields',
            //'comments',
            //'revisions',
            'page-attributes',
            //'post-formats'
        ],
        //'register_meta_box_cb' => 
        //'taxonomies' => [],
        'has_archive' => false,
        'rewrite' => false,
        //'permalink_epmask' =>
        'query_var' => false,
        'can_export' => true,
        'delete_with_user' => false,
        //'show_in_rest' => false,
        //'rest_base' =>
        //'rest_controller_class' =>
    ];

    public static function instance () {
        static $_instance = null;
        
        if ($_instance === null) {
            $_instance = new GetRETSSearch();
        }
        
        return $_instance;
    }

    private function __construct() { 
        if ( !is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
            $this->initParams();
            
            $this->getRETS = new GetRETS(GetRETSSettings::getOption('CUSTOMER_KEY'));
            $this->searchClient = $this->getRETS->getListing();
            if (GetRETSSettings::getOption('DISABLE_CACHE')) {
                $this->searchClient = $this->getRETS->getRETSListing();
            }

            add_action('init', [$this, 'registerPostTypes']);
            add_action('pre_get_posts', [$this, 'setQuery'] );
            add_action('template_redirect', [$this, 'handleTemplates']);
            
            add_filter('posts_pre_query', [$this, 'getPost'], 10, 2);
            add_filter('the_posts', [$this, 'addPosts']);
            add_filter('post_class', [$this, 'addClasses']);
            add_filter('get_post_metadata', [$this, 'handleMetadata'], 10, 4);
            add_filter('wp_get_attachment_image_src', [$this, 'getImage'], 10, 4);
            add_filter('post_type_link', [$this, 'getLink'], 10, 5);
        }
    }
    
    public function registerPostTypes() {
        register_post_type(GetRETSSearch::POST_TYPE, $this->getRETSPostType);
        remove_post_type_support(GetRETSSearch::POST_TYPE, 'comments');
    }
    
    public function removeComments() {
        return GetRETSSettings::get('PLUGIN_DIR') . '/views/frontend/comments.php';
    }
    
    public function handleTemplates() {
        if (is_singular()) {
            if (GetRETSSearch::POST_TYPE == get_post_type()) {
                // Kill the comments template.
                add_filter('comments_template', [$this, 'removeComments'], 20);
                // Remove comment-reply script for themes that include it indiscriminately
                wp_deregister_script('comment-reply');
                // feed_links_extra inserts a comments RSS link
                remove_action('wp_head', 'feed_links_extra', 3);
            }
        }
    }

    /**
     * 
     * @param string  $postLink The post's permalink.
     * @param WP_Post $post      The post in question.
     * @param bool    $leavename Whether to keep the post name.
     * @param bool    $sample    Is it a sample permalink.
     */
    public function getLink($postLink, $post, $leavename, $sample) {
        $url = $postLink;
        if (GetRETSSearch::POST_TYPE == get_post_type()) {
            $url = get_bloginfo('url') . '/?' . http_build_query(['post_type' => $post->post_type, 
                                                                  'p' => GetRETSPost::MAGIC_POST_NUMBER,
                                                                  'gr_det' => $post->guid]);
        }
        return $url;
    }
    
    /**
     * 
     * @param null|array|string $value     The value get_metadata() should return - a single metadata value, or an array of values.
     * @param type $objectId
     * @param type $metaKey
     * @param type $single                  Whether to return only the first value of the specified $meta_key.
     * @return type
     */
    public function handleMetadata($value, $objectId, $metaKey, $single) {
        if (GetRETSSearch::POST_TYPE == get_post_type()) {
            if ('_thumbnail_id' === $metaKey) {
                return $objectId; // Just return this object id and we'll pick it up in the getImage function
            }
        }
        return null;
    }

    /**
     * 
     * @param array|false  $image         Either array with src, width & height, icon src, or false.
     * @param int          $attachmentId  Image attachment ID.
     * @param string|array $size          Size of image. Image size or array of width and height values
     *                                    (in that order). Default 'thumbnail'.
     * @param bool         $icon          Whether the image should be treated as an icon. Default false.
     */
    public function getImage($image, $attachmentId, $size, $icon) {
        $output = $image;
        if (GetRETSSearch::POST_TYPE == get_post_type()) {
            $details = $this->getListingDetails($attachmentId);
            
            if (!empty($details)) {
                $width = 320;
                $height = 210;
                
                if ($icon) {
                    $width = 20;
                    $height = 20;
                }
                
                if (is_array($size)) {
                    $width = (int)$size[0];
                    $height = (int)$size[1];
                }
                
                $output = [$this->searchClient->imageUrl($details['listingSource'], $details['listingType'], $details['listingID'], 0, $width, $height), 
                           $width, 
                           $height, 
                           false];            
            }
        }
        return $output;
    }
    
    private function getListingDetails($id) {
        $details = null;

        $index = GetRETSPost::MAGIC_POST_NUMBER - $id;
        if ($index >= 0 && $index < count($this->listingPosts)) {
            $listing = $this->listingPosts[$index];
            $details = GetRETSPost::parseGuid($listing->guid);
        }
        
        return $details;
    }
    
    public function addClasses($classes) {
        $all = $classes;
        if (in_array('getrets_listing', $classes)) {
            // Add thumbnails to the post
            if (current_theme_supports( 'post-thumbnails' )) {
                $all[] = 'has-post-thumbnail';
            }
        }
        return $all;
    }
    
    public function setQuery($query) {
        $this->query = $query;  // Don't remove this, it's used to preserve the query for later use
    }
    
    public function getPost($posts, $query) {
        if ($query->is_single) {
            if (!empty($query->query)) {
                if (array_key_exists('p', $query->query)) {
                    $p = $query->query['p'];
                    if (GetRETSPost::MAGIC_POST_NUMBER == $p) {
                        $guid = array_key_exists('gr_det', $_POST) ? $_POST['gr_det'] : (array_key_exists('gr_det', $_GET) ? $_GET['gr_det'] : null);
                        if (!empty($guid)) {
                            $details = GetRETSPost::parseGuid($guid);
                            $listing = $this->searchClient->details($details['listingSource'], $details['listingType'], $details['listingID']);
                            if (!empty($listing)) {
                                $posts = $this->hashListings([$listing]);
                            }
                        }
                    }                    
                }                
            }
        }
        
        return $posts;
    }
    
    public function addPosts($posts) {
        $results = [];
        
        if (isset($this->query)) {
            if ($this->query->is_search) {
                if ($this->parameters["advanced"]) {
                    $listings = $this->searchClient->search($this->parameters["keywords"], $this->parameters["maxPrice"], $this->parameters["minPrice"], $this->parameters["residential"], $this->parameters["land"], $this->parameters["commercial"]);
                }
                else {
                    $listings = $this->searchClient->searchByKeyword($this->parameters["keywords"]);
                }
                if (!empty($listings)) {
                    $results = $this->hashListings($listings);
                }
            }
        }
        
        return array_merge($posts, $results);
    }
    
    private function hashListings($listings) {
        for ($i = 0; $i < count($listings); $i++) {
            $this->listingPosts[] = GetRETSPost::get($this->query, $this->searchClient, $listings[$i], GetRETSPost::MAGIC_POST_NUMBER - $i);
        }
        
        return $this->listingPosts;
    }
    public static function get($key) {
        $value = null;
        if (array_key_exists($key, GetRETSSearch::instance()->parameters)) {
            $value = GetRETSSearch::instance()->parameters[$key];
        }
        return $value;
    }
        
    public function initParams() {
        // Which superglobal to use
        $src = array_key_exists("getrets_search", $_POST) ? $_POST : $_GET;
        
        $this->parameters["keywords"] = (array_key_exists("s", $src) ? $src["s"] : null );
        $this->parameters["advanced"] = (array_key_exists("getrets_advanced", $src) ? $src["getrets_advanced"] : null );
        $this->parameters["minPrice"] = (array_key_exists("getrets_minPrice", $src) ? $src["getrets_minPrice"] : null );
        $this->parameters["maxPrice"] = (array_key_exists("getrets_maxPrice", $src) ? $src["getrets_maxPrice"] : null );
        $this->parameters["residential"] = (array_key_exists("getrets_residential", $src) ? $src["getrets_residential"] : null );
        $this->parameters["land"] = (array_key_exists("getrets_land", $src) ? $src["getrets_land"] : null );
        $this->parameters["commercial"] = (array_key_exists("getrets_commercial", $src) ? $src["getrets_commercial"] : null );

        if (array_key_exists("getrets_search", $src)) {
            do_action("getrets_search", $this->parameters);
        }
    }
    
}
