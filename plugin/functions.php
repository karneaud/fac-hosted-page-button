<?php
/**
 * Plugin functions
 * @version 1.0.0
 */ 
use WPFac\HostedPage\Src\Templating;
use WPFac\HostedPage\Lib\Fac as FacHostedPage;

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

if(!function_exists('wp_fac_hosted_page_display_payment_button')) {
	/**
	 * Dislays an html markup payment link button for FAC hosted page
	 * 
	 * @method wp_fac_hosted_page_display_payment_button
	 * @param array $data an array with keys:- currency, amount, transaction_id, text
	 * 
	 */ 
	function wp_fac_hosted_page_display_payment_button($params) {
    
    	print do_shortcode(sprintf("[%s amount='%0.2f' currency='' transacion_id='' text='']", 
                             			WP_FAC_HOSTED_PAGE_TEXT_DOMAIN, 
                             			$params['amount'],
                            			$params['currency'],
                            			$params['transaction_id'],
                            			$params['text']
                            	));
    }
}

if(!function_exists('wp_fac_hosted_page_get_payment_link')) {
	/**
	 * Gets FAC hosted page payment link
	 * 
	 * @method wp_fac_hosted_pagee_get_payment_link
	 * @param array $data an array of currency, amount, transaction_id
	 * @return Array|WP_Error returns payment link url or WP_Error
	 */ 
	function wp_fac_hosted_pagee_get_payment_link($data) {
    	$fac = new FacHostedPage();
       	$response = $fac->hosted_page_request([	'amount' => number_format($data['amount'], 2, '.', ''),
                								'currency' => $data['currency'],
                								'cardHolderResponseUrl' => site_url(sprintf('/%s/response', WP_FAC_HOSTED_PAGE_TEXT_DOMAIN )),
                								'transactionId' => $data['transaction_id']
                							]);
    
    	if(array_key_exists('error', $response))  $response = new \WP_Error($response['code'], $response['message'], $data );
    	
    	return $response;
    }
}

if(!function_exists('wp_fac_hosted_page_get_result')) {
	/**
	 * Gets FAC results from hosted page transaction
	 * 
	 * @method wp_fac_hosted_page_get_result
	 * @param string $token returned token from hosted page link transaction
	 * @return Array|WP_Error returns results data information or WP_Error
	 */ 
	function wp_fac_hosted_page_get_result($token) {
    	$fac = new FacHostedPage();
       	$response = $fac->hosted_page_result($token);
    	if(array_key_exists('error', $response))  $response = new \WP_Error($response['code'], $response['message'] );
    	
    	return $response;
    }
}
