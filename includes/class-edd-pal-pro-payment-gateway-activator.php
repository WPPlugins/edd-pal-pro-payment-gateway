<?php

/**
 * Fired during plugin activation
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Edd_Pal_Pro_Payment_Gateway_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() { 
		
		if( !in_array( 'easy-digital-downloads/easy-digital-downloads.php',apply_filters('active_plugins',get_option('active_plugins'))) && !is_plugin_active_for_network( 'easy-digital-downloads/easy-digital-downloads.php' )   ) { 
			wp_die( "<strong>Easy Digital Download Paypal Pro Payment Gateway Integration</strong> Plugin requires <strong>Easy Digital Download</strong> <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
		}
		global $wpdb,$woocommerce;
		set_transient( '_easy_digital_download_paypal_pro_welcome_screen', true, 30 );

	}

}
