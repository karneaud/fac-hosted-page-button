<?php
/**
 * Plugin functions
 * @version 1.0.0
 */ 
use WPFac\HostedPage\Button\Src\Templating;
use WPFac\HostedPage\Button\Lib\Fac as FacHostedPage;

if(!function_exists('check_confirm_url')) {
	/**
	 * Checks whether or not the current url path.
	 * 
	 * @method check_confirm_url
	 * @param string $path the url path of the current url
	 * @return bool True if the current path is $path
	 */ 
	function check_confirm_url( $path = '') {
    	return false !== strpos( $_SERVER[ 'REQUEST_URI' ], $path );
	}
}

if(!function_exists('wp_fac_hosted_page_button_display_payment_button')) {
	/**
	 * Dislays an html markup payment link button for FAC hosted page
	 * 
	 * @method wp_fac_hosted_page_button_display_payment_button
	 * @param array $data an array with keys:- currency, amount, transaction_id, text
	 * 
	 */ 
	function wp_fac_hosted_page_button_display_payment_button($params) {
    
    	print do_shortcode(sprintf("[%s amount='%0.2f' currency='%s' transaction_id='%s' text='%s']", 
                             			WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . "_payment_button", 
                             			$params['amount'],
                            			$params['currency'],
                            			$params['transaction_id'],
                            			$params['text']
                            	));
    }
}

if(!function_exists('wp_fac_hosted_page_button_get_payment_link')) {
	/**
	 * Gets FAC hosted page payment link
	 * 
	 * @method wp_fac_hosted_pagee_get_payment_link
	 * @param array $data an array of currency, amount, transaction_id
	 * @return Array|WP_Error returns payment link url or WP_Error
	 */ 
	function wp_fac_hosted_page_button_get_payment_link($data) {
    	$fac =  wp_fac_hosted_page();
       	$response = $fac->hosted_page_request([	'amount' => number_format($data['amount'], 2, '.', ''),
                								'currency' => $data['currency'],
                								'cardHolderResponseUrl' => site_url(sprintf('/%s/response/%s', WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, $data['transaction_id'] )),
                								'transactionId' => $data['transaction_id'],
                                               	'pageSet' => WP_FAC_HOSTED_PAGE_BUTTON_PAGE_SET,
                                               	'pageName' => WP_FAC_HOSTED_PAGE_BUTTON_PAGE_NAME
                							]);
    
    	if(array_key_exists('error', $response))  $response = new \WP_Error($response['code'], $response['message'], $data );
    	
    	return $response;
    }
}

if(!function_exists('wp_fac_hosted_page_button_get_result')) {
	/**
	 * Gets FAC results from hosted page transaction
	 * 
	 * @method wp_fac_hosted_page_button_get_result
	 * @param string $token returned token from hosted page link transaction
	 * @return Array|WP_Error returns results data information or WP_Error
	 */ 
	function wp_fac_hosted_page_button_get_result($token) {
    	$fac =  wp_fac_hosted_page();
       	$response = $fac->hosted_page_result($token);
    	if(array_key_exists('error', $response))  $response = new \WP_Error($response['code'], $response['message'] );
    	
    	return $response;
    }
}
if(!function_exists('wp_fac_hosted_page')) {
	/**
	 * Returns Fac class object
	 * @method wp_fac_hosted_page
	 * @return Fac returns Fac class object
	 */ 
	function wp_fac_hosted_page() {
		return new FacHostedPage([
        	'merchantId' => WP_FAC_HOSTED_PAGE_BUTTON_MERCHANT_ID,
        	'merchantPassword' => WP_FAC_HOSTED_PAGE_BUTTON_MERCHANT_PASSWD,
        	'testMode' => WP_FAC_HOSTED_PAGE_BUTTON_TEST_MODE
        ]);
	}
}
