=== Plugin Name ===
Contributors: Joshua Williams
Donate link: 
Tags: RETS, Realty, Real Estate, IDX, MLS, Real Estate Listings, RETS Feed, MLS Search, IDX Search, Listings
Requires at least: 4.6.1
Tested up to: 4.7
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Instantly add real estate listing data to your website.  Allows listings, from multiple feeds, to appear within your site as native content.

== Description ==

Instantly add real estate listing data to your website.  This WordPress plugin will allow your listings, from multiple feeds, to appear within your site as native content, treated just like other content on your website.  All of this is done through an integration with GetRETS&reg; from timitek, llc.

== Installation ==

= From Within WordPress =

1. From the WordPress administration dashboard, select **Plugins** - **Add New**.
2. Search for **GetRETS**.
3. Click the **Activate** button.

= Alternate Install (With Zip File) =

**Note** - It might be necessary to provide ftp information for this method.

1. Download the ***.zip** file.
2. From the WordPress administrators dashboard, select **Plugins** - **Add New**.
3. Click the **Upload Plugin** button.
4. Upload the ***.zip** file that was previously downloaded.
5. After uploading, activate the plugin.

= Manual Installation =

1. Download the ***.zip** file.
2. Extract the contents of the ***.zip** into the <code>wp-content/plugins</code> directory of your WordPress installation.

= Setup =

**Note** - Ensure the Plugin has been activated in the WordPress administration dashboard before continuing.

Access the **GetRETS** settings from the WordPress administrators dashboard.

From the WordPress administration dashboard, select **Settings** - **GetRETS**.

There are two settings for you to configure. 

**Customer Key**: The customer key is the unique key assigned to you from [www.timitek.com](http://www.timitek.com). 

**Cache Settings**: By default, GetRETS will pre-fetch and cache all of your listings from the MLS systems. It will maintain this cache for you automatically and allow you to fetch your listing details even if your MLS system is offline. It is not recommended that you disable this, however, you can optionally disable the cache and have all of your listings fetched directly from the MLS system on each request. Some MLS systems do not allow this sort of traffic, and you must be sure this is what you want to do before checking this box.

**Show Thumbnail**: Some WordPress templates will show a featured image tied to a post.  When a template with this feature enabled is used, having GetRETS also display a thumbnail, might be a bit redundant.  By unchecking this box GetRETS will not present a thumbnail associated with the listing on the search results.

= Congratulations =

You have successfully installed GetRETS and visitors to your site can immediately start using your site to search for realty listings using the regular

== Advanced Listing Search Widget ==

= About =

GetRETS integrates with the default WordPress search immediately out of the box after setup. However, if you would like to enable a more advanced search, the GetRETS plugin also includes a Search Widget, which once enabled, will allow visitors to your site to specify additional constraints to search listings by.

In addition to the generic keyword search, the following constraints are made available;

* Minimum Price
* Maximum Price
* Residential Listings
* Land Listings
* Commercial Listings

= Enabling =

* From the WordPress administration dashboard, select **Appearance** - **Widgets**.
* From the **Available Widgets** section, select **GetRETS Search**.
* Based on the theme you have installed, select the sidebar / area where you want your widget to be displayed at on your site.
* Click the **Add Widget** button
* You may customize the title to be used for the for the widget.

= Finally =

Now your sites visitors can perform more advanced listing searches!

== Shortcodes ==

= Advanced Search =

In addition to the the search widget, the GetRETS plugin provides a <code>[getrets_search]</code> shortcode for you to use in a post or page to create a more customized search page. This short code provides a search form with the same advanced searching functionality as the widget.

= How To Use =

Place the following line in any page / post.

<code>[getrets_search]</code>

== Extending Via CSS ==

The post content detail elements are marked up with several CSS classes that can be used to customize the look and feel of the listing details post.

= Main Content =

<code>getrets-content</code>

This is class used for the main div that surrounds all of the content for the listing details post.

= Sections =

Each of the 4 sections are wrapped in a div that has it’s own class. 

* Details - <code>getrets-details</code> 
* Description - <code>getrets-description</code> 
* Features - <code>getrets-features</code> 
* Photos - <code>getrets-features</code>

= Titles =

<code>getrets-title</code>

This is the title for each of the 4 sections. 

* Details 
* Description 
* Features 
* Photos

= Detail Entries =

<code>getrets-detail</code>

Each entry in the **Details** section has a div around it with the <code>getrets-detail</code> class applied to it.

= Labels / Values =

<code>getrets-label</code>
<code>getrets-value</code>

This <code>getrets-label</code> class is applied to each label used for each detail item in the Details section, as well as the **Provided By:** label.

Likewise, the <code>getrets-value</code> class is applied to each value after the label.

= Photos =

<code>getrets-photo</code>

Each photo has the <code>getrets-photo</code> class applied to it.

= Further Details =

For further information examine the markup at;

<code>wp-content/plugins/getrets/views/frontend/content.php</code>

== Extending Via JavaScript ==

In addition to extending the the listing details post via custom styles in your theme, you can also extend functionality via JavaScript.

= listingLoaded Function =

Each listing detail post will attempt to inject listing detail information and a list of images for the listing into a global function if your theme enables it.

To take advantage of this create a public function with the following syntax, that will be called when a listing detail post is displayed.

<code>
/**
* Function that is called by GetRETS when a listing
* detail post is loaded.
* 
* listing - JSON object representing the details
*           of the listing
* images  - an array of image urls associated
*           with this listing
*/
function listingLoaded(listing, images) 
{ 
    alert(listing.description);
}
</code>

= Element Attributes =

Each element that is rendered is also rendered with an intuitive id to make it easy to allow for DOM manipulation.

For further information examine the markup at;

<code>wp-content/plugins/getrets/views/frontend/content.php</code>

== Frequently Asked Questions ==

= Why should I use this plugin? =

* Because it's easy, just install it and plug in your customer key and it works right out of the box!
* Because you care about your search engine rankings.  The listings appear natively within your site so they will appear as original content on your site.
* Because there isn't anything you have to maintain.  No database, no IDX, no fuss!

== Screenshots ==

1. Settings - GetRETS
2. Create your own search page using the [getrets-search] shortcode
3. Take advantage of the advanced listing search search widget
4. View listing searches natively in your site like any other post
5. View a detailed post for listings with detailed information and photos

== Changelog ==

= 1.0.0 =

* Return listings in search results
* View listing details as a custom post type
* Advanced search shortcode
* Advanced search widget
* Listing detail post rendered with CSS classes and JavaScript hooks

= 1.0.1 =

Added support for cUrl as backup for use in working with API when allow_url_fopen is not enabled

= 1.0.2 =

Removed duplicate ID's from search result excerpt

= 1.0.3 =

Fix for php versions before 5.5 (no empty checks) - Line 118 of GetRETS.php.

== Upgrade Notice ==

= 1.0.0 =

Initial Release

= 1.0.1 =

Added support for cUrl as backup for use in working with API when allow_url_fopen is not enabled

= 1.0.2 =

Removed duplicate ID's from search result excerpt

= 1.0.3 =

Fix for php versions before 5.5 (no empty checks) - Line 118 of GetRETS.php.

= 1.0.4 =

Replace boolval with other methods in order to support older versions of PHP
