<?php
namespace WPFac\HostedPage\Button\Src;

if ( ! defined( 'ABSPATH' ) ) exit;

use WPFac\HostedPage\Button\Src\Templating;

/**
 * Shortcode class for rendering in front end
 *
 * @author     Kendall Arneaud
 * @package    wp-fac-hosted-page-button
 */
class Shortcode {

		protected $template;
		/**
		 * Add Shortcode
		 *
		 * @return Void
		 */
		public function __construct() {

        	$this->template = new Templating();
			add_shortcode( WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_page' , array( $this, 'display_page' ) );
        	add_shortcode( WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_payment_button', [$this, 'create_payment_buton'] );
		}

	   /**
	    * Displays the Fac Hosted Page Results from transaction
		* @param Array $atts
		* @return result Html markup
		*/
		public function display_page($atts) {
			
            $transaction_id = get_query_var('transaction_id', null);
        	$data = shortcode_atts( array(
										'page' => 'page.success'
									), $atts );
        	$template = "{$data['page']}";
			if(isset($_GET['ID']) && isset($_GET['RespCode']) && isset($_GET['ReasonCode'])) {
            	$data = wp_fac_hosted_page_button_get_result($_GET['ID']);
            	if(is_wp_error($data)) {
                	$template = "page.error";
                    $data = ['code' => $data->get_error_code(), 'message' => $data->get_error_message(), 'transaction_id' => $transaction_id ];
                }
            }
        	
			ob_start();
			$this->template->get_template_part("part", $template, $data );
        	$file_content = ob_get_contents();
			ob_end_clean();
        
        	return $file_content;
		}
		/**
	    * Displays a button for the authorized Fac Hosted Page url
		* @param Array $atts
		* @return result Html markup
		*/
		public function create_payment_buton($atts)
        {
        	$data = shortcode_atts( array(
            							'amount' => '',
            							'currency' => 'USD',
            							'transaction_id' => '',
            							'text' => 'Pay Now'
									), $atts );
        	$template = 'payment.button';
    		$payment_link = wp_fac_hosted_page_button_get_payment_link($data);
    		if(is_wp_error($payment_link )) {
        		$template = 'payment.button.error';
        		$data = ['code' => $payment_link->get_error_code(), 'message' => $payment_link->get_error_message() ];
        	} else {
        		$data = [
        			'text' => $data['text'],
        			'fac_hosted_page_url' => $payment_link['data']['url']
                ];
        	}
        	
        	ob_start();
			$this->template->get_template_part("part",$template, $data );
        	$file_content = ob_get_contents();
			ob_end_clean ();
        
        	return $file_content;
        }
	}
