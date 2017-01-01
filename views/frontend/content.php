<div id='getrets-content' class='getrets-content'>
    <div id='getrets-details' class='getrets-details'>
        <div id='getrets-details-title' class='getrets-title'>
            Details
        </div>
        <?php if ($listing->address) { ?>
        <div id='getrets-detail-address' class='getrets-detail'>
            <span id='getrets-label-address' class='getrets-label'>Address:</span> <span id='getrets-value-address' class='getrets-value'><?= $listing->address; ?></span>
        </div>
        <?php } ?>
        <?php if ($listing->listPrice) { ?>
        <div id='getrets-detail-listprice' class='getrets-detail'>
            <span id='getrets-label-listprice' class='getrets-label'>List Price:</span> <span id='getrets-value-listprice' class='getrets-value'><?= $listing->listPrice; ?></span>
        </div>
        <?php } ?>
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
    <div id='getrets-description' class='getrets-description'>
        <div id='getrets-description-title' class='getrets-title'>
            Description
        </div>
        <?= $description; ?>
    </div>
    <?php if ($listing->features) { ?>
    <div id='getrets-features' class='getrets-features'>
        <div id='getrets-features-title' class='getrets-title'>
            Features
        </div>
        <ul>
            <?php foreach( $listing->features as $item ): ?>
            <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>        
    </div>
    <?php } ?>
    <?php if ($listing->photoCount > 0) { ?>
    <div id='getrets-photos' class='getrets-photos'>
        <div id='getrets-photos-title' class='getrets-title'>
            Photos
        </div>
        <?php
        for ($i = 0; $i < $listing->photoCount; $i++) {
            $img = $searchClient->imageUrl($listing->listingSourceURLSlug, $listing->listingTypeURLSlug, $listing->listingID, $i);	
            echo "<div class='getrets-photo-responsive'><div class='getrets-photo-container'><a target='_blank' href='" . $img . "' class='getrets-photos-link'><img src='" . $img . "?newWidth=200&maxHeight=200' class='getrets-photo' width='200' height='200' /></a></div></div>"; 
        }
        unset($photo);
        ?>
        <div class="clearfix"></div>
    </div>
    <?php } ?>
    <div id='getrets-providedby' class='getrets-providedby'>
        <span id='getrets-providedby-label' class='getrets-label'>Provided By:</span> <span id='getrets-providedby-value' class='getrets-value'><?= $listing->providedBy; ?></span>
    </div>
<script type='text/javascript'>
<?php
echo "var listing = ". json_encode($listing) . ";\n";
echo "var listingImages = [";
for ($i = 0; $i < $listing->photoCount; $i++) {
    $img = $searchClient->imageUrl($listing->listingSourceURLSlug, $listing->listingTypeURLSlug, $listing->listingID, $i);
    echo "'" . $img . "',";
}
echo "];";
?>
document.addEventListener("DOMContentLoaded", function(event) { if (typeof listingLoaded === "function") { listingLoaded(listing, listingImages); } });
/***********************************************************\
 * To inject this listing into your own custom javascript, *
 * create a global function as below and it will be called *
 * when the page finishes loading with the listing data.   *
\***********************************************************/
//function listingLoaded(listing, images) { alert(listing.description); }
</script>
</div>