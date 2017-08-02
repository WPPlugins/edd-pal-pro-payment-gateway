<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://multidots.com
 * @since      1.0.0
 *
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Edd_Pal_Pro_Payment_Gateway
 * @subpackage Edd_Pal_Pro_Payment_Gateway/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Edd_Pal_Pro_Payment_Gateway_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/edd-pal-pro-payment-gateway-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_deregister_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( 'wp-pointer' );
		//wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/edd-pal-pro-payment-gateway-admin.js', array('jquery'), $this->version, false );

	}
	
	public function edd_paypal_pro_subscription() {
	
		 if (!get_option('edd_plugin_notice_shown')  && !empty( $_GET['section'] ) && $_GET['section']=='edd_paypal_pro') {
		 	$current_user = wp_get_current_user();
   			 echo '<div id="edd_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_edd" class="regular-text" name="txt_user_sub_edd" value="'.$current_user->user_email.'"></p></div>';
   			
        } 
	}
	
	   public function wp_add_plugin_userfnpaypal() {
    	$email_id= $_POST['email_id'];
    	$log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('user_email'=>$email_id,'plugin_site' => $log_url,'status' => 1,'plugin_id' => '28','activation_date'=>$cur_date)),
    	'cookies' => array()));
		update_option('edd_plugin_notice_shown', 'true');
    }
     public function hide_subscribe_eddpaypal() {
    	$email_id= $_POST['email_id'];
    	update_option('edd_plugin_notice_shown', 'true');
    } 
    
    // Function for welcome screen page 
    
    public function welcome_easy_digital_download_paypal_pro_screen_do_activation_redirect ( ) { 
    	
    	if (!get_transient('_easy_digital_download_paypal_pro_welcome_screen')) {
			return;
		}
		
		// Delete the redirect transient
		delete_transient('_easy_digital_download_paypal_pro_welcome_screen');

		// if activating from network, or bulk
		if (is_network_admin() || isset($_GET['activate-multi'])) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect(add_query_arg(array('page' => 'edd-pal-pro-payment-gateway&tab=about'), admin_url('index.php')));
    } 
    
     public function welcome_pages_screen_easy_digital_download_paypal_pro ( ){ 
    	add_dashboard_page(
		'Easy Digital Download Paypal Pro Payment Gateway Integration Dashboard', 'Easy Digital Download Paypal Pro Payment Gateway Integration Dashboard', 'read', 'edd-pal-pro-payment-gateway',  array( $this,'welcome_screen_content_easy_digital_download_paypal_pro' ) );
    } 
    
    public function  welcome_screen_easy_digital_download_paypal_pro_remove_menus ( ){ 
    	remove_submenu_page( 'index.php', 'edd-pal-pro-payment-gateway' );
    } 
    
    public function welcome_screen_content_easy_digital_download_paypal_pro () {  
    	
    	global $wpdb;
		$current_user = wp_get_current_user();
		if (!get_option('edd_plugin_notice_shown') ) {
   			 echo '<div id="edd_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_edd" class="regular-text" name="txt_user_sub_edd" value="'.$current_user->user_email.'"></p></div>';
        }
    	 ?>
    	 <style type="text/css">.ui-widget-overlay.ui-front {display: none;}</style>
    	 <div class="wrap about-wrap">
            <h1 style="font-size: 2.1em;"><?php printf(__('Welcome to Easy Digital Download Paypal Pro Payment Gateway Integration', 'edd-pal-pro-payment-gateway')); ?></h1>

            <div class="about-text woocommerce-about-text">
        <?php
        $message = '';
        printf(__('%s EDD Paypal Pro Payment Gateway integrates the PayPal Pro (Do Direct Payment Gateway) with Easy Digital Download Plugin.', 'edd-pal-pro-payment-gateway'), $message);
        ?>
                <img class="version_logo_img" src="<?php echo plugin_dir_url(__FILE__) . 'images/edd-pal-pro-payment-gateway.png'; ?>">
            </div>

        <?php
        $setting_tabs_wc = apply_filters('easy_digital_download_paypal_pro_tab', array("about" => "Overview", "other_plugins" => "Checkout our other plugins" ));
        $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
        $aboutpage = isset($_GET['page'])
        ?>
            <h2 id="woo-extra-cost-tab-wrapper" class="nav-tab-wrapper">
            <?php
            foreach ($setting_tabs_wc as $name => $label)
            echo '<a  href="' . home_url('wp-admin/index.php?page=edd-pal-pro-payment-gateway&tab=' . $name) . '" class="nav-tab ' . ( $current_tab_wc == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
            ?>
            </h2>
                <?php
                foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
                	switch ($setting_tabkey_wc) {
                		case $current_tab_wc:
                			do_action('easy_digital_download_paypal_pro_' . $current_tab_wc);
                			break;
                	}
                }
                ?>
            <hr />
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('/wp-admin/edit.php?post_type=download&page=edd-settings&tab=gateways&section=edd_paypal_pro'); ?>"><?php _e('Go to Easy Digital Download Paypal Pro Payment Gateway Integration Settings', 'edd-pal-pro-payment-gateway'); ?></a>
            </div>
        </div>	
    
    <?php } 
    
    public function easy_digital_download_paypal_pro_about ( ) { ?>  
    	<div class="changelog">
            </br>
           	<style type="text/css">
				p.easy_digital_download_paypal_pro_overview {max-width: 100% !important;margin-left: auto;margin-right: auto;font-size: 15px;line-height: 1.5;}.easy_digital_download_paypal_pro_content_ul ul li {margin-left: 3%;list-style: initial;line-height: 23px;}
			</style>  
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">
                    <div>
                        <p class="easy_digital_download_paypal_pro_overview"><?php _e('EDD Paypal Pro Payment Gateway integrates the PayPal Pro (Do Direct Payment Gateway) with Easy Digital Download Plugin. This will enable a new payment method for your EDD store.', 'banner-management-for-woocommerce'); ?></p>
                    </div>
                        <p class="easy_digital_download_paypal_pro_overview"><strong>Plugin Functionality:</strong></p>
                    	<div class="easy_digital_download_paypal_pro_content_ul"> 
                    		<ul>
                    			<li>Add PayPal Pro (Do Direct Payment) payment gateway to easy digital download.</li>
                    			<li>User-friendly admin settings page.</li>
                    			<li>Log the all order response.</li>
                    		</ul>
                    	</div>
                    	
                </div>
            </div>
        </div>	
    
    <?php }
    
    
    public function easy_digital_download_paypal_pro_other_plugins ( ){ 
   	global $wpdb;
         $url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/checkout_other_plugin.php';
    	 $response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'advance-flat-rate-shipping-method-for-woocommerce'),
    	'cookies' => array()));
    	
    	$response_new = array();
    	$response_new = json_decode($response['body']);
		$get_other_plugin = maybe_unserialize($response_new);
		
		$paid_arr = array();
		?>

        <div class="plug-containter">
        	<div class="paid_plugin">
        	<h3>Paid Plugins</h3>
	        	<?php foreach ($get_other_plugin as $key=>$val) { 
	        		if ($val['plugindesc'] =='paid') {?>
	        			
	        			
	        		   <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>	
	        			
	        			
	        		<?php }else {
	        			
	        			$paid_arry[$key]['plugindesc']= $val['plugindesc'];
	        			$paid_arry[$key]['pluginimage']= $val['pluginimage'];
	        			$paid_arry[$key]['pluginurl']= $val['pluginurl'];
	        			$paid_arry[$key]['pluginname']= $val['pluginname'];
	        		
	        	?>
	        	
	         
	            <?php } }?>
           </div>
           <?php if (isset($paid_arry) && !empty($paid_arry)) {?>
           <div class="free_plugin">
           	<h3>Free Plugins</h3>
                <?php foreach ($paid_arry as $key=>$val) { ?>  	
	            <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>
	            <?php } }?>
           </div>
          
        </div>

    <?php
   
   } 
   
   public function easy_digital_download_paypal_pro_pointers_footer ( ) { 
	   	$admin_pointers = easy_digital_download_paypal_pro_admin_pointers();
		    ?>
		    <script type="text/javascript">
		        /* <![CDATA[ */
		        ( function($) {
		            <?php
		            foreach ( $admin_pointers as $pointer => $array ) {
		               if ( $array['active'] ) {
		                  ?>
		            $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
		                content: '<?php echo $array['content']; ?>',
		                position: {
		                    edge: '<?php echo $array['edge']; ?>',
		                    align: '<?php echo $array['align']; ?>'
		                },
		                close: function() {
		                    $.post( ajaxurl, {
		                        pointer: '<?php echo $pointer; ?>',
		                        action: 'dismiss-wp-pointer'
		                    } );
		                }
		            } ).pointer( 'open' );
		            <?php
		         }
		      }
		      ?>
		        } )(jQuery);
		        /* ]]> */
		    </script>
		<?php	
	   	
   	}  

} 

function easy_digital_download_paypal_pro_admin_pointers ( ) { 
		global $wpdb;
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	    $version = '1_0'; // replace all periods in 1.0 with an underscore
	    $prefix = 'easy_digital_download_paypal_pro_admin_pointers' . $version . '_';
	
	    $new_pointer_content = '<h3>' . __( 'Welcome to Welcome to Easy Digital Download Paypal Pro Payment Gateway Integration' ) . '</h3>';
	    $new_pointer_content .= '<p>' . __( 'EDD Paypal Pro Payment Gateway integrates the PayPal Pro (Do Direct Payment Gateway) with Easy Digital Download Plugin.' ) . '</p>';
	
	    return array(
	        $prefix . 'easy_digital_download_paypal_pro_admin_pointers' => array(
	            'content' => $new_pointer_content,
	            'anchor_id' => '#menu-posts-download',
	            'edge' => 'left',
	            'align' => 'left',
	            'active' => ( ! in_array( $prefix . 'easy_digital_download_paypal_pro_admin_pointers', $dismissed ) )
	        )
	    );
}
