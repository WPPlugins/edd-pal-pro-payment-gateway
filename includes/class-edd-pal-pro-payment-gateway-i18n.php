<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Edd_Pal_Pro_Payment_Gateway_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'edd-pal-pro-payment-gateway',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
