<?php
/**
* Plugin Name: Notify Engage
* Version: 0.1
* Author: Imsuccesses
* Author URI: https://www.imsuccesses.com/
* Description: All in one website conversion tool. Add 50+ powerful notifications including social proof, lead capture, promotional, support, feedback and social share. Build and manage all in single platform.
* Text Domain: notify-engage
* Domain Path: languages
*/

/**
* Notify Engage Class
*/
class NotifyEngage {
	/**
	* Constructor
	*/
	public function __construct() {

		// Plugin Details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'notify-engage'; // Plugin Folder
        $this->plugin->displayName  = 'Notify Engage'; // Plugin Name
        $this->plugin->version      = '0.1';
        $this->plugin->folder       = plugin_dir_path( __FILE__ );
        $this->plugin->url          = plugin_dir_url( __FILE__ );
        $this->plugin->db_welcome_dismissed_key = $this->plugin->name . '_welcome_dismissed_key';

        // Check if the global wpb_feed_append variable exists. If not, set it.
        if ( ! array_key_exists( 'wpb_feed_append', $GLOBALS ) ) {
              $GLOBALS['wpb_feed_append'] = false;
        }

		// Hooks
		add_action( 'admin_init', array( &$this, 'registerSettings' ) );
        add_action( 'admin_menu', array( &$this, 'adminPanelsAndMetaBoxes' ) );
       
        // Frontend Hooks
        add_action( 'wp_head', array( &$this, 'frontendHeader' ) );
	}

   	/**
	* Register Settings
	*/
	function registerSettings() {
		register_setting( $this->plugin->name, 'pixel_key', 'trim' );
	}

	/**
    * Register the plugin settings panel
    */
    function adminPanelsAndMetaBoxes() {
    	add_submenu_page( 'options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'adminPanel' ) );
	}

    /**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
		// only admin user can access this page
		if ( !current_user_can( 'administrator' ) ) {
			echo '<p>' . __( 'Sorry, you are not allowed to access this page.', 'insert-headers-and-footers' ) . '</p>';
			return;
		}

    	// Save Settings
        if ( isset( $_REQUEST['submit'] ) ) {
        	// Check nonce
			if ( !isset( $_REQUEST[$this->plugin->name.'_nonce'] ) ) {
	        	// Missing nonce
	        	$this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'insert-headers-and-footers' );
        	} elseif ( !wp_verify_nonce( $_REQUEST[$this->plugin->name.'_nonce'], $this->plugin->name ) ) {
	        	// Invalid nonce
	        	$this->errorMessage = __( 'Invalid nonce specified. Settings NOT saved.', 'insert-headers-and-footers' );
        	} else {
	        	// Save
				// $_REQUEST has already been slashed by wp_magic_quotes in wp-settings
				// so do nothing before saving
	    		update_option( 'pixel_key', sanitize_text_field($_REQUEST['pixel_key']) );
	    		
	    		$this->message = __( 'Settings Saved.', 'insert-headers-and-footers' );
			}
        }

        // Get latest settings
        $this->settings = array(
			'pixel_key' => esc_html( wp_unslash( get_option( 'pixel_key' ) ) )
        );

    	// Load Settings Form
        include_once( $this->plugin->folder . '/views/settings.php' );
    }

    /**
	* Loads plugin textdomain
	*/
	function loadLanguageFiles() {
		load_plugin_textdomain( 'insert-headers-and-footers', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	* Outputs script / CSS to the frontend header
	*/
	function frontendHeader() {
		$this->output( 'pixel_key' );
	}

	
	/**
	* Outputs the given setting, if conditions are met
	*
	* @param string $setting Setting Name
	* @return output
	*/
	function output( $setting ) {
		// Ignore admin, feed, robots or trackbacks
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
			return;
		}

		// Get meta
		$meta = get_option( $setting );
		if ( empty( $meta ) ) {
			return;
		}
		if ( trim( $meta ) == '' ) {
			return;
		}

		// Output
		echo '<!-- Pixel Code for https://notifyengage.com/ -->
			<script async src="https://notifyengage.com/pixel/'.$meta.'"></script>
			<!-- END Pixel Code -->';
	}
}

$ne = new NotifyEngage();