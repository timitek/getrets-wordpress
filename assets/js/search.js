(function() {

function getSearchWidgetAdvancedValue() {
    var isAdvanced = false;
    var searchForm = jQuery('.search-form.getrets-searchwidget');
    if (searchForm) {
        isAdvanced = searchForm.hasClass('advanced-search');
    }
    return isAdvanced;
}

function setSearchWidgetAdvanced(advancedSearch) {
    var searchForm = jQuery('.search-form.getrets-searchwidget');
    var hiddenAdvancedState = jQuery('.getrets-searchwidget-advanced-state');

    if (hiddenAdvancedState) {
        hiddenAdvancedState.val( advancedSearch ? 1 : 0 );
    }
    
    if (searchForm) {
        if (advancedSearch) {
            searchForm.addClass('advanced-search');
        }
        else {
            searchForm.removeClass('advanced-search');
            jQuery('#gr_mnp').val('');
            jQuery('#gr_mxp').val('');
            jQuery('#gr_r').prop('checked', false);
            jQuery('#gr_l').prop('checked', false);
            jQuery('#gr_c').prop('checked', false);
        }
    }
}

function setupSearchWidgetAdvanced() {
    
    var hiddenAdvancedState = jQuery('.getrets-searchwidget-advanced-state');
    
    setSearchWidgetAdvanced(hiddenAdvancedState ? Number(hiddenAdvancedState.val()) : 0);
    
    var advancedLink = jQuery('.getrets-searchwidget-advanced');
    
    if (advancedLink) {
        advancedLink.click(function () {
            setSearchWidgetAdvanced(!getSearchWidgetAdvancedValue());
        });
    }
}

jQuery( document ).ready( function ( e ) {
    setupSearchWidgetAdvanced();
});

})();