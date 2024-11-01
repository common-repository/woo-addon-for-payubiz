<?php
/*
  Plugin Name: WooCommerce Addon for Payubiz
  Plugin URI: http://wapinfosolutions.com/woocommerce-payubiz
  Description: Extends WooCommerce. Provides a <a href="https://www.payubiz.in/">PayUbiz India</a> gateway for WooCommerce.
  Version: 1.0
  Author: wapinfosystems
  Author URI: http://wapinfosolutions.com
  Requires at least: 3.8
  Tested up to: 4.8
 */


// Init PayU IN Gateway after WooCommerce has loaded
add_action('plugins_loaded', 'init_payubiz_money_gateway', 0);

/**
 * init_payu_money_gateway function.
 *
 * @description Initializes the gateway.
 * @access public
 * @return void
 */
function init_payubiz_money_gateway() {
    // If the WooCommerce payment gateway class is not available, do nothing
    if (!class_exists('WC_Payment_Gateway'))
        return;

    // Localization
    load_plugin_textdomain('woocommerce_payubiz_money', false, dirname(plugin_basename(__FILE__)) . '/languages');

    require_once( plugin_basename('classes/payubiz.class.php') );

    add_filter('woocommerce_payment_gateways', 'add_payubiz_gateway');

    /**
     * add_gateway()
     *
     * Register the gateway within WooCommerce.
     *
     * @since 1.0.0
     */
    function add_payubiz_gateway($methods) {
        $methods[] = 'WCPZ_Gateway_Payubiz';
        return $methods;
    }

}

// Add the Indian Rupee to the currency list
add_filter('woocommerce_currencies', 'wcpz_add_indian_rupee');

function wcpz_add_indian_rupee($currencies) {
    $currencies['INR'] = __('Indian Rupee', 'woocommerce_payubiz_money');
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'wcpz_add_indian_rupee_currency_symbol', 10, 2);

function wcpz_add_indian_rupee_currency_symbol($currency_symbol, $currency) {
    switch ($currency) {
        case 'INR': $currency_symbol = 'Rs.';
            break;
    }
    return $currency_symbol;
}
