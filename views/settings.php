<div class="wrap">
    <h2><?php echo $this->plugin->displayName; ?> &raquo; <?php esc_html_e( 'Settings', 'insert-headers-and-footers' ); ?></h2>

    <?php
    if ( isset( $this->message ) ) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>
        <?php
    }
    if ( isset( $this->errorMessage ) ) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>
        <?php
    }
    ?>

    <div id="poststuff">
    	<div id="post-body" class="metabox-holder columns-2">
    		<!-- Content -->
    		<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
	                <div class="postbox">
	                    <h3 class="hndle"><?php esc_html_e( 'Key Settings', 'insert-headers-and-footers' ); ?></h3>

	                    <div class="inside">
		                    <form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">
		                    	<p>
		                    		<label for="pixel_key"><strong><?php esc_html_e( 'Pixel API Key', 'insert-headers-and-footers' ); ?></strong></label>
		                    		<input type="text" name="pixel_key" id="pixel_key" class="widefat"  style="font-family:Courier New;" value="<?php echo $this->settings['pixel_key']; ?>" />
		                    		<?php echo 'Please add your pixel key from <a href="https://notifyengage.com/install" target="_blank">Notify Engage</a> to track information.'; ?>
		                    	</p>
		                    	<?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
		                    	<p>
									<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php esc_html_e( 'Save', 'insert-headers-and-footers' ); ?>" />
								</p>
						    </form>
	                    </div>
	                </div>
	                <!-- /postbox -->
				</div>
				<!-- /normal-sortables -->
    		</div>
    		<!-- /post-body-content -->
    		<!-- /postbox-container -->
    	</div>
	</div>
</div>