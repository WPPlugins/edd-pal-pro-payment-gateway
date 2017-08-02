<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Edd_Pal_Pro_Payment_Gateway {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Edd_Pal_Pro_Payment_Gateway_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'edd-pal-pro-payment-gateway';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        add_action('http_api_curl', array($this, 'edd_http_api_curl_ex_add_curl_parameter'), 10, 3);
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Edd_Pal_Pro_Payment_Gateway_Loader. Orchestrates the hooks of the plugin.
     * - Edd_Pal_Pro_Payment_Gateway_i18n. Defines internationalization functionality.
     * - Edd_Pal_Pro_Payment_Gateway_Admin. Defines all hooks for the admin area.
     * - Edd_Pal_Pro_Payment_Gateway_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-edd-pal-pro-payment-gateway-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-edd-pal-pro-payment-gateway-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-edd-pal-pro-payment-gateway-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-edd-pal-pro-payment-gateway-public.php';


        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-edd-payment-gateway-logger.php';


        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/gateways/class-edd-paypal-pro-helper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/gateways/class-edd-paypal-pro.php';


        $this->loader = new Edd_Pal_Pro_Payment_Gateway_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Edd_Pal_Pro_Payment_Gateway_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Edd_Pal_Pro_Payment_Gateway_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Edd_Pal_Pro_Payment_Gateway_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        add_filter('edd_payment_gateways', 'register_edd_paypal_pro');
        add_filter('edd_settings_sections_gateways', 'edd_paypal_pro_settings_section');
        add_filter('edd_settings_gateways', 'edd_paypal_pro_settings');
        $this->loader->add_action('admin_init', $plugin_admin, 'edd_paypal_pro_subscription');
        $this->loader->add_action('wp_ajax_add_plugin_user_eddpaypal', $plugin_admin, 'wp_add_plugin_userfnpaypal');
        $this->loader->add_action('wp_ajax_hide_subscribe_eddpaypal', $plugin_admin, 'hide_subscribe_eddpaypal');

        $this->loader->add_action('admin_init', $plugin_admin, 'welcome_easy_digital_download_paypal_pro_screen_do_activation_redirect');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_pages_screen_easy_digital_download_paypal_pro');


        $this->loader->add_action('easy_digital_download_paypal_pro_other_plugins', $plugin_admin, 'easy_digital_download_paypal_pro_other_plugins');
        $this->loader->add_action('easy_digital_download_paypal_pro_about', $plugin_admin, 'easy_digital_download_paypal_pro_about');
        $this->loader->add_action('admin_print_footer_scripts', $plugin_admin, 'easy_digital_download_paypal_pro_pointers_footer');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_screen_easy_digital_download_paypal_pro_remove_menus', 999);
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Edd_Pal_Pro_Payment_Gateway_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        add_action('edd_gateway_edd_paypal_pro', 'edd_paypal_pro_process_payment_own');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Edd_Pal_Pro_Payment_Gateway_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    public function edd_http_api_curl_ex_add_curl_parameter($handle, $r, $url) {
        if (strstr($url, 'https://') && strstr($url, '.paypal.com')) {
            curl_setopt($handle, CURLOPT_VERBOSE, 1);
            curl_setopt($handle, CURLOPT_SSLVERSION, 6);
        }
    }

}
