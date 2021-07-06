<?php
namespace WPFac\HostedPage\Src;

if ( ! defined( 'ABSPATH' ) ) exit;

use WPFac\HostedPage\Src\Templating;

/**
 * Shortcode class for rendering in front end
 *
 * @author     Kendall Arneaud
 * @package    wp-fac-hosted-page
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
			add_shortcode( PLUGIN_TEXT_DOMAIN . '_page' , array( $this, 'display_page' ) );
        	add_shortcode( PLUGIN_TEXT_DOMAIN . '_button', [$this, 'create_payment_buton'] );
		}

	   /**
	    * Shortcode callback
		*
		* @param Array $atts
		*
		* @return Html
		*/
		public function display_page($atts) {

			$data = shortcode_atts( array(
										'page' => 'payment_page',
            							'transaction_id' => get_query_var('transaction_id', null)
									), $atts );
        	$template = "part-{$data['page']}";
			if(isset($_GET['ID']) && isset($_GET['RespCode']) && isset($_GET['ReasonCode'])) {
            	$result = wp_fac_hosted_page_get_result($_GET['ID']);
            	if(is_wp_error($result)) {
                	$template = "part-page.error";
                    $data = ['code' => $result->get_error_code(), 'message' => $result->get_error_message(), 'transaction_id' => $data['transaction_id'] ];
                } else { 
                	$template = "part-page.success";
                	$data = $result;
               }
            }
        	
			return $this->template->render($template, $data, true );
		}

		public function create_payment_buton($atts)
        {
        	$data = shortcode_atts( array(
										'method' => 'hosted_page',
            							'text' => 'Pay Now',
            							'nounce' => wp_create_nonce( '_fac_nounce' ),
            							'redirect_url' => '',
            							'amount' => '',
            							'currency' => 'USD',
            							'transaction_id' => '',
									), $atts );
        
			return $this->template->render('part-payment.button', $data );
        }
	}
