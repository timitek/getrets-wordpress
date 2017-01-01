<div id='getrets-excerpt' class='getrets-excerpt'>
    <?php if (GetRETSSettings::getOption('SHOW_THUMBNAIL')) { ?>
    <div class='getrets-thumbnail-container'>
        <a class='getrets-thumbnail-link' href='<?= $url; ?>'><img class='getrets-thumbnail' width='200' height='200' alt='...' src='<?= $searchClient->imageUrl($listing->listingSourceURLSlug, $listing->listingTypeURLSlug, $listing->listingID, 0, 200, 200); ?>' /></a>
    </div>
    <?php } ?>
    <div id='getrets-excerpt-details' class='getrets-excerpt-details'>
        <?php if ($listing->listingTypeURLSlug) { ?>
        <div id='getrets-detail-listingtype' class='getrets-listingtype'>
            <span id='getrets-label-listingtype' class='getrets-label'>Listing Type:</span> <span id='getrets-value-listingtype' class='getrets-value'><?= $listing->listingTypeURLSlug; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->listingID) { ?>
        <div id='getrets-detail-listingid' class='getrets-listingid'>
            <span id='getrets-label-listingid' class='getrets-label'>Listing ID:</span> <span id='getrets-value-listingid' class='getrets-value'><?= $listing->listingID; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->squareFeet) { ?>
        <div id='getrets-detail-squarefeet' class='getrets-detail'>
            <span id='getrets-label-squarefeet' class='getrets-label'>Square Feet:</span> <span id='getrets-value-squarefeet' class='getrets-value'><?= $listing->squareFeet; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->beds) { ?>
        <div id='getrets-detail-beds' class='getrets-detail'>
            <span id='getrets-label-beds' class='getrets-label'>Beds:</span> <span id='getrets-value-beds' class='getrets-value'><?= $listing->beds; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->baths) { ?>
        <div id='getrets-detail-baths' class='getrets-detail'>
            <span id='getrets-label-baths' class='getrets-label'>Baths:</span> <span id='getrets-value-baths' class='getrets-value'><?= $listing->baths; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->acres) { ?>
        <div id='getrets-detail-acres' class='getrets-detail'>
            <span id='getrets-label-acres' class='getrets-label'>Acres:</span> <span id='getrets-value-acres' class='getrets-value'><?= $listing->acres; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->lot) { ?>
        <div id='getrets-detail-lot' class='getrets-detail'>
            <span id='getrets-label-lot' class='getrets-label'>Lot:</span> <span id='getrets-value-lot' class='getrets-value'><?= $listing->lot; ?></span>
        </div>
        <?php } ?>
    </div>
</div>
<div class="clearfix"></div>
<div id='getrets-providedby' class='getrets-providedby'>
    <span id='getrets-providedby-label' class='getrets-label'>Provided By:</span> <span id='getrets-providedby-value' class='getrets-value'><?= $listing->providedBy; ?></span>
</div>
