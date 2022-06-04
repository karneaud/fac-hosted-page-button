<?php
namespace WPFac\HostedPage\Button\Lib;

/**
 * Implimentation of WordPress inbuilt API class
 *
 * Usage:
 *
 * $api = new FAC_HOSTED_PAGE_BUTTON_API();
 * $api->endpoint = 'endpoint_url'
 * $api->header = array( "key: $val" )
 * $api->data_type = 'xml' or 'json'
 * $api->call_type = 'GET' or 'POST'
 * $api->call();
 * $data = $api->parse();
 *
 * @author     Kendall Arneaud
 * @package    fac-hosted-page-button
 */
if ( ! class_exists( 'Api' ) ) {

	class Api {


		/**
		 * @var String
		 */
		public $endpoint;


		/**
		 * @var Array
		 */
		public $header;


		/**
		 * @var String
		 */
		public $data_type;

		/**
		 * @var String
		 */
		public $call_type;


		/**
		 * Define the properties inside a instance
		 *
		 * @return Void
		 */
		 public function __construct() {

			 $this->endpoint  = '';
			 $this->header    = array();
			 $this->data_type = ''; //xml or json
			 $this->call_type = '';
		 }


		/**
		 * Define the necessary database tables
		 * @params $params The paramters to build the request
		 * @return Array
		 */
		public function build($params) {

			$args = array(
						'headers' => $this->headers,
            			'method' => $this->call_type,
						);

			return array_merge($args, $params);
		}


		/**
		 * Define the variables for db table creation
		 *
		 * @return Array
		 */
		public function call($params) {
			$result = wp_remote_request($this->endpoint, $this->build($params));
        	return $result;
		}


		/**
		 * Check options and tables and output the info to check if db install is successful
		 *
		 * @return Array
		 */
		public function parse($data) {

			call_user_func( array( $this, $this->data_type ), $data );
		}


		/**
		 * Parse XML data type
		 *
		 * @return Array
		 */
		public function xml( $data ) {

			libxml_use_internal_errors( true );
			$parsed = ( ! $data || $data == '' ? false : simplexml_load_string( $data ) );

			if ( ! $parsed ) {
				return false;
				libxml_clear_errors();
			} else {
				return $parsed;
			}
		}


		/**
		 * Parse JSON data type
		 *
		 * @return Array
		 */
		public function json( $data ) {

			$parsed = ( ! $data || $data == '' ? false : json_decode( $data, 1 ) );
			return $parsed;
		}
	}
} ?>
