<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GetRETSPost
 *
 * @author josh
 */
class GetRETSPost {
    
    const MAGIC_POST_NUMBER = 2147483646; // Maximum 32 bit integer minus 1
    
    private $listing = null;
    
    private $query = null;
    
    private $searchClient = null;
    
    public function __construct($query, $searchClient, $listing = null) {
        $this->query = $query;
        $this->searchClient = $searchClient;
        $this->listing = $listing;
    }
    

    private function listingContentDescriptionLand() {
        $content = '';

        if (!empty($this->listing->acres)) {
            $content .= $this->listing->acres . (strpos(strtoupper($this->listing->acres), 'ACRE') === false ? ' acres' : '');
            $content .= ' of land';
        }

        if (!empty($this->listing->lot)) {
            if (strlen($content)) {
                $content .= ' on a';
            }
            $content .= $this->listing->lot . (strpos(strtoupper($this->listing->lot), 'lot') === false ? ' lot' : '');
        }

        return $content;
    }
    
    private function listingContentDescriptionLayout() {
        $content = '';

        if ($this->listing->squareFeet) {
            $content .= $this->listing->squareFeet . (strpos(strtoupper($this->listing->squareFeet), 'sq') === false ? ' square foot' : '');
        }

        if ($this->listing->beds) {
            if (strlen($content)) {
                $content .= ' ';
            }
            $content .= $this->listing->beds . (strpos(strtoupper($this->listing->beds), 'bed') === false ? ' bed' : '');
        }

        if ($this->listing->baths) {
            if (strlen($content)) {
                $content .= ' ';
            }
            $content .= $this->listing->baths . (strpos(strtoupper($this->listing->baths), 'bed') === false ? ' bath' : '');
        }

        return $content;
    }
    
    private function listingContentDescriptionCommercial() {
        $content = 'Commercial property';
        
        $layout = $this->listingContentDescriptionLayout();
        if (strlen($layout)) {
            $content .= ' with ' . $layout;
        }
        
        $land = $this->listingContentDescriptionLand();
        if (strlen($land)) {
            $content .= ' on' . $land;
        }

        return $content;
    }
    
    private function listingContentDescriptionResidential() {
        $content = 'House';
        
        $layout = $this->listingContentDescriptionLayout($this->listing);
        if (strlen($layout)) {
            $content .= ' with ' . $layout;
        }
        
        $land = $this->listingContentDescriptionLand($this->listing);
        if (strlen($land)) {
            $content .= ' on' . $land;
        }

        return $content;
    }
    
    private function listingContentDescription() {
        $content = "Click on the listing to see more!";
        
        switch (strtoupper($this->listing->listingTypeURLSlug)) {
            case 'LAND':
                $content = $this->listingContentDescriptionLand();
                if (!strlen($content)) {
                    $content .= 'Land';
                }
                break;
            case 'COMMERCIAL':
                $content = $this->listingContentDescriptionCommercial();
                break;
            case 'RESIDENTIAL':
            default:
                $content = $this->listingContentDescriptionResidential();
                break;            
        }
        
        if (!empty($this->listing->address)) {
            $content .= ' located at ' . $this->listing->address;
        }
        
        if (!empty($this->listing->listPrice)) {
            $content .= ' for ' . $this->listing->listPrice;
        }
        
        if (!empty($this->listing->providedBy)) {
            $content .= ' listed by ' . $this->listing->providedBy;
        }
        
        return $content;
    }    
    
    private function listingContent() {
        $content = (empty($this->listing->description) ? $this->listingContentDescription() : $this->listing->description);
        if (!$this->query->is_search) {
            $template = new GetRETSTemplateEngine(GetRETSSettings::get('PLUGIN_DIR') . '/views/frontend/content.php');
            $template->set('listing', $this->listing);
            $template->set('searchClient', $this->searchClient);
            $template->set('post', $this);
            $template->set('description', $content);
            $content = $template->render();
        }
        return $content;
    }
    
    private function getExcerpt($post) {
        $template = new GetRETSTemplateEngine(GetRETSSettings::get('PLUGIN_DIR') . '/views/frontend/excerpt.php');
        $template->set('listing', $this->listing);
        $template->set('searchClient', $this->searchClient);
        $template->set('url', get_bloginfo('url') . '/?' . http_build_query(['post_type' => $post->post_type, 
                                                          'p' => GetRETSPost::MAGIC_POST_NUMBER,
                                                          'gr_det' => $post->guid]));
        return $template->render();
    }
    
    public function getPost($newId = null) {
        $post = new stdClass;
        
        $post->ID = (empty($newId) ? GetRETSPost::MAGIC_POST_NUMBER : $newId);
        $post->filter = 'raw'; // Must include or there are errors
        $post->post_title = $this->listing->listPrice . ' - ' . $this->listing->address;
        $post->post_author = $this->listing->providedBy;
        $post->post_content = $this->listingContent();
        $post->post_type = GetRETSSearch::POST_TYPE;
        $post->post_status = 'publish';
        $post->page_template = 'default';
        $post->guid = GetRETSPost::getGuid($this->listing);
        $post->post_excerpt = $this->getExcerpt($post);
        
        return new WP_Post( $post );
    }
    
    public static function getGuid($listing) {
        return $listing->listingSourceURLSlug . '__' . $listing->listingTypeURLSlug . '__' . $listing->listingID;
    }
    
    public static function parseGuid($guid) {
        $exploded = explode('__', $guid);
        return [
            'listingSource' => $exploded[0],
            'listingType' => $exploded[1],
            'listingID' => $exploded[2]
        ];
    }
    
    public static function get($query, $searchClient, $listing, $newId = null) {
        $s = new GetRETSScripts();
        $s->addStyle('css/post.css'); 

        $posting = new GetRETSPost($query, $searchClient, $listing);
        return $posting->getPost($newId);
    }

}
