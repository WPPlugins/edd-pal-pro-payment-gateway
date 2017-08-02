<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://multidots.com
 * @since             1.0.0
 * @package           Edd_Pal_Pro_Payment_Gateway
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Digital Download Paypal Pro Payment Gateway Integration
 * Plugin URI:        http://multidots.com
 * Description:       EDD Paypal Pro Payment Gateway integrates the PayPal Pro (Do Direct Payment Gateway) with Easy Digital Download Plugin.
 * Version:           1.0.2
 * Author:            Multidots
 * Author URI:        http://multidots.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       edd-pal-pro-payment-gateway
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!defined('EDD_PLUGIN_URL')) {
    define('EDD_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('EDD_LOG_DIR')) {
    $upload_dir = wp_upload_dir();
    define('EDD_LOG_DIR', $upload_dir['basedir'] . '/edd-pal-pro-payment-gateway/');
}
if (!defined('EDD_PLUGIN_DIR_PATH')) {
    define('EDD_PLUGIN_DIR_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-edd-pal-pro-payment-gateway-activator.php
 */
function activate_edd_pal_pro_payment_gateway() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-edd-pal-pro-payment-gateway-activator.php';
	Edd_Pal_Pro_Payment_Gateway_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-edd-pal-pro-payment-gateway-deactivator.php
 */
function deactivate_edd_pal_pro_payment_gateway() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-edd-pal-pro-payment-gateway-deactivator.php';
	Edd_Pal_Pro_Payment_Gateway_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_edd_pal_pro_payment_gateway' );
register_deactivation_hook( __FILE__, 'deactivate_edd_pal_pro_payment_gateway' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-edd-pal-pro-payment-gateway.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_edd_pal_pro_payment_gateway() {

	$plugin = new Edd_Pal_Pro_Payment_Gateway();
	$plugin->run();

}
run_edd_pal_pro_payment_gateway();
