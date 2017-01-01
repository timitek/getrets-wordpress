<form role="search" method="post" class="search-form getrets-searchwidget" action="<?= get_bloginfo('url'); ?>">
    <input type="hidden" class="getrets-searchwidget-advanced-state" name="getrets_advanced" value="<?php echo GetRETSSearch::get("advanced"); ?>" />
    <label>
        <span class="screen-reader-text">Search for:</span>
        <input type="search" class="search-field" placeholder="City, Address or Listing #..." value="<?php echo GetRETSSearch::get("keywords"); ?>" name="s" id="s">
    </label>
    <label class="advanced-field">
        <span class="screen-reader-text">Min Price:</span>
        <input type="search" class="search-field" placeholder="Min Price" value="<?php echo GetRETSSearch::get("minPrice"); ?>" name="getrets_minPrice" id="getrets_minPrice">
    </label>
    <label class="advanced-field">
        <span class="screen-reader-text">Max Price:</span>
        <input type="search" class="search-field" placeholder="Max Price" value="<?php echo GetRETSSearch::get("maxPrice"); ?>" name="getrets_maxPrice" id="getrets_maxPrice">
    </label>
    <div class="advanced-field">
        <input type="checkbox" value="true" <?php echo (GetRETSSearch::get("residential") ? 'checked' : ''); ?> name="getrets_residential" id="getrets_residential"> <span>Residential</span>
    </div>
    <div class="advanced-field">
        <input type="checkbox" value="true" <?php echo (GetRETSSearch::get("land") ? 'checked' : ''); ?> name="getrets_land" id="getrets_land"> <span>Land</span>
    </div>
    <div class="advanced-field">
        <input type="checkbox" value="true" <?php echo (GetRETSSearch::get("commercial") ? 'checked' : ''); ?> name="getrets_commercial" id="getrets_commercial"> <span>Commercial</span>
    </div>
    <div class="getrets-searchwidget-advanced">
        <span class="edit-link"><a class="post-edit-link" href="javascript:void(0);">Advanced</a></span>
    </div>
    <button name="getrets_search" type="submit" class="submit submit-search" value="s">
        <span class="search-text">Search</span>
    </button>
</form>
