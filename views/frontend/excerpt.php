<div class='getrets-excerpt'>
    <?php if (GetRETSSettings::getOption('SHOW_THUMBNAIL')) { ?>
    <div class='getrets-thumbnail-container'>
        <a class='getrets-thumbnail-link' href='<?= $url; ?>'><img class='getrets-thumbnail' width='200' height='200' alt='...' src='<?= $searchClient->imageUrl($listing->listingSourceURLSlug, $listing->listingTypeURLSlug, $listing->listingID, 0, 200, 200); ?>' /></a>
    </div>
    <?php } ?>
    <div class='getrets-excerpt-details'>
        <?php if ($listing->listingTypeURLSlug) { ?>
        <div class='getrets-listingtype'>
            <span class='getrets-label'>Listing Type:</span> <span class='getrets-value'><?= $listing->listingTypeURLSlug; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->listingID) { ?>
        <div class='getrets-listingid'>
            <span class='getrets-label'>Listing ID:</span> <span class='getrets-value'><?= $listing->listingID; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->squareFeet) { ?>
        <div class='getrets-detail'>
            <span class='getrets-label'>Square Feet:</span> <span class='getrets-value'><?= $listing->squareFeet; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->beds) { ?>
        <div class='getrets-detail'>
            <span class='getrets-label'>Beds:</span> <span class='getrets-value'><?= $listing->beds; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->baths) { ?>
        <div class='getrets-detail'>
            <span class='getrets-label'>Baths:</span> <span class='getrets-value'><?= $listing->baths; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->acres) { ?>
        <div class='getrets-detail'>
            <span class='getrets-label'>Acres:</span> <span class='getrets-value'><?= $listing->acres; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->lot) { ?>
        <div class='getrets-detail'>
            <span class='getrets-label'>Lot:</span> <span class='getrets-value'><?= $listing->lot; ?></span>
        </div>
        <?php } ?>
    </div>
</div>
<div class="clearfix"></div>
<div class='getrets-providedby'>
    <span class='getrets-label'>Provided By:</span> <span class='getrets-value'><?= $listing->providedBy; ?></span>
</div>
