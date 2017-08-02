<?php

if (!defined('ABSPATH'))
    exit;

function register_edd_paypal_pro($gateways) {
    $gateways['edd_paypal_pro'] = array(
        'admin_label' => __('EDD PayPal Pro', 'edd-payment-gateway'),
        'checkout_label' => __('PayPal Pro', 'edd-payment-gateway')
    );
    return $gateways;
}

function edd_paypal_pro_settings_section($sections) {
    $sections['edd_paypal_pro'] = __('EDD PayPal Pro', 'edd-payment-gateway');
    return $sections;
}

function edd_paypal_pro_settings($settings) {
	
	    $paypal_for_edd_pro_settings = edd_payment_gateway_paypal_pro_settings();
    return array_merge($settings, $paypal_for_edd_pro_settings);
}

function edd_payment_gateway_paypal_pro_settings() {
    $edd_paypal_pro_settings = array(
        'edd_paypal_pro' => array(
            array(
                'id' => 'paypal_for_edd_pro_sandbox_credentials',
                'name' => '<strong>' . __('PayPal Pro Settings', 'edd-payment-gateway') . '</strong>',
                'type' => 'header',
            ),
            array(
                'id' => 'paypal_for_edd_pro_testmode',
                'name' => __('Enable Testmode ', 'edd-payment-gateway'),
                'type' => 'checkbox',
                'desc' => __('Enable Paypal Pro Sandbox/Test Mode', 'edd-payment-gateway')
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_sandbox_username',
                'name' => __('Sandbox API Username ', 'edd-payment-gateway'),
                'desc' => sprintf(__('Create sandbox accounts and obtain API credentials from within your <a href="%s" target="_blank">PayPal developer account</a>.', 'credit-card-payment'), 'https://developer.paypal.com/'),
                'type' => 'text'
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_sandbox_password',
                'name' => __('Sandbox API Password ', 'edd-payment-gateway'),
                'type' => 'password'
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_sandbox_signature',
                'name' => __('Sandbox API Signature ', 'edd-payment-gateway'),
                'type' => 'password'
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_live_username',
                'name' => __('Live API Username ', 'edd-payment-gateway'),
                'desc' => __('Get your live account API credentials from your PayPal account profile under the API Access section or by using <a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-api-run" target="_blank">here.</a>', 'edd-payment-gateway'),
                'type' => 'text'
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_live_password',
                'name' => __('Live API Password ', 'edd-payment-gateway'),
                'type' => 'password'
            ),
            array(
                'id' => 'paypal_for_edd_api_pro_live_signature',
                'name' => __('Live API Signature ', 'edd-payment-gateway'),
                'type' => 'password'
            ),
            array(
                'id' => 'paypal_for_edd_pro_invoice_id_prefix',
                'name' => __('Invoice ID Prefix', 'edd-payment-gateway'),
                'desc' => __('Add a prefix to the invoice ID sent to PayPal. This can resolve duplicate invoice problems when working with multiple websites on the same PayPal account.', 'edd-payment-gateway'),
                'type' => 'text'
            ),
            array(
                'id' => 'paypal_for_edd_pro_debug',
                'name' => __('Debug Log', 'edd-payment-gateway'),
                'desc' => sprintf(__('Enable logging <code>%s</code>', 'edd-payment-gateway'), paypal_for_edd_log_file_path('paypal_for_edd_paypal_pro')),
                'type' => 'checkbox'
            )
        ),
    );
    return $edd_paypal_pro_settings;
}

function edd_paypal_pro_process_payment_own($purchase_data) {
	
    $EDD_PayPal_Pro_Helper = new EDD_PayPalPro_Helper();
    $EDD_PayPal_Pro_Helper->edd_paypal_pro_process_payment($purchase_data);
}

if (!function_exists('paypal_for_edd_log_file_path')) {

    function paypal_for_edd_log_file_path($handle) {
        return trailingslashit(EDD_LOG_DIR) . $handle . '_' . sanitize_file_name(wp_hash($handle)) . '.log';
    }

}