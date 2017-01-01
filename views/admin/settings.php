<div class="wrap">
    <h1>GetRETS Settings</h1>

    <?php if (isset($_GET['message']) && $_GET['message'] == '1') { ?>
        <div id='message' class='updated fade'><p><strong>Settings Saved</strong></p></div>
    <?php } ?>    
    <form method="post" action="admin-post.php">
        <input type="hidden" name="action" value="getrets_save_settings" />
        
        <!-- Adding security through hidden referrer field -->
        <?php wp_nonce_field('getrets_settings'); ?>
        
        <p>
            Please supply the customer key given to you by timitek.<br /><br />
            
            You must have an active subscription for this to plugin to work correctly<br />
            To set up a subscription, please visit <a href="http://www.timitek.com" target="_blank">www.timitek.com</a>.
        </p>
        
        <h2 class="title">GetRETS Settings</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <td><label for="getrets_customer_key">Customer Key</label></td>
                    <td><input name="getrets_customer_key" id="getrets_customer_key" type="text" value="<?php echo esc_html(GetRETSSettings::getOption('CUSTOMER_KEY')); ?>" class="regular-text code"></td>
                </tr>
                <tr>
                    <td><label for="getrets_disable_cache">Cache Settings</label></td>
                    <td>
                        <input type="checkbox" name="getrets_disable_cache" id="getrets_disable_cache" <?php echo (GetRETSSettings::getOption('DISABLE_CACHE') ? "checked='checked'" : "") ?> />
                        Disable Cache
                        <p class="description">It is highly recommended that you do not disable the cache.</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="getrets_show_thumbnail">Show Thumbnail</label></td>
                    <td>
                        <input type="checkbox" name="getrets_show_thumbnail" id="getrets_show_thumbnail" <?php echo (GetRETSSettings::getOption('SHOW_THUMBNAIL') ? "checked='checked'" : "") ?> />
                        Have GetRETS show the thumbnail
                        <p class="description">If your template shows featured images, having this enabled, could cause duplicate thumnails.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>        
    </form>
</div>
