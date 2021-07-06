<?php
namespace WPFac\HostedPage;

use WPFac\HostedPage\Src\Install as Install;
use WPFac\HostedPage\Src\Cpt as Cpt;
use WPFac\HostedPage\Src\Db as Db;
use WPFac\HostedPage\Src\Settings as Settings;
use WPFac\HostedPage\Src\Widget as Widget;
use WPFac\HostedPage\Src\Metabox as Metabox;
use WPFac\HostedPage\Src\Shortcode as Shortcode;
use WPFac\HostedPage\Src\RestApi as RestApi;
use WPFac\HostedPage\Lib\Fac as FacHostedPage;
use WPFac\HostedPage\Lib\Cron as Cron;
use WPFac\HostedPage\Lib\Script as Script;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main plugin object to define the plugin
 * Follow: https://codex.wordpress.org/Plugin_API for details
 *
 * @author     Kendall Arneaud
 * @package    wp-fac-hosted-page
 */
if ( ! class_exists( 'PluginLoader' ) ) {

	final class PluginLoader {

		/**
		 * @var String
		 */
		protected $version = '1.0.0';


		/**
		 * Plugin Instance.
		 *
		 * @var PLUGIN_BUILD the PLUGIN Instance
		 */
		protected static $_instance;


		/**
		 * Text domain to be used throughout the plugin
		 *
		 * @var String
		 */
		protected static $text_domain = PLUGIN_TEXT_DOMAIN;


		/**
		 * Minimum PHP version allowed for the plugin
		 *
		 * @var String
		 */
		protected static $php_ver_allowed = '7.3';


		/**
		 * DB tabble used in plugin
		 *
		 * @var String
		 */
		protected static $plugin_table = PLUGIN_TEXT_DOMAIN . "_table";


		/**
		 * Plugin listing page links, along with Deactivate
		 *
		 * @var Array
		 */
		protected static $plugin_page_links = array(
			array(
				'slug' => 'wp-plugin-framework.php?page=menu_page_callback',
				'label' => 'Settings'
			) );


		/**
		 * Main Plugin Instance.
		 *
		 * @return PLUGIN_BUILD
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
				self::$_instance->init();
			}

			return self::$_instance;
		}


		/**
		 * Install plugin setup
		 *
		 * @return Void
		 */
		public function installation() {

			if (class_exists('WPFac\\HostedPage\\Src\\Install')) {

				$install = new Install();
				$install->text_domain = self::$text_domain;
				$install->php_ver_allowed = self::$php_ver_allowed;
				$install->plugin_page_links = self::$plugin_page_links;
				$install->execute();
			}

			// If CPT exists, include taht and flush the rewrite rules
			// if ( class_exists( 'WPFac\\HostedPage\\Src\\Cpt' ) ) new Cpt();
			// flush_rewrite_rules();
		}


		/**
		 * Custom corn class, register it while activation
		 *
		 * @return Void
		 */
		public function cron_activation() {

			if ( class_exists( 'WPFac\\HostedPage\\Lib\\Cron' ) ) {

				$cron = new Cron();
				$schedule = $cron->schedule_task(
							array(
							'timestamp' => current_time('timestamp'),
							//'schedule' can be 'hourly', 'daily', 'weekly' or anything custom as defined in PLUGIN_CRON
							'recurrence' => 'schedule',
							// Use custom_corn_hook to hook into any cron process, anywhere in the plugin.
							'hook' => 'custom_cron_hook'
						) );
			}

		}
    
		public function page_install() {
        	wp_insert_post([
            	'post_title'=>'FAC Hosted Page', 
  				'post_type'=> 'page', 
  				'post_content'=> '<!-- wp:shortcode -->[ '. PLUGIN_TEXT_DOMAIN . 'page="payment_page"]<!-- /wp:shortcode -->',
            	'post_name' => PLUGIN_TEXT_DOMAIN
            ]);
        	
        }
    
    	public function page_uninstall() {
        
        	$args=	array(
        			'name' => PLUGIN_TEXT_DOMAIN,
        			'post_type' => 'page',
        			'post_status' => 'publish',
       				'posts_per_page' => 1
    		);
   			
        	$my_posts = get_posts( $args );
    		if( !$my_posts ) {
       			 return null ;
        	}
        
        	wp_delete_post( $my_posts[0]->ID, true);
        }

		/**
		 * Install plugin data
		 *
		 * @return Void
		 */
		public function db_install() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Db' ) ) {

				$db = new Db();
				$db->table = self::$plugin_table;
				$db->sql = "ID mediumint(9) NOT NULL AUTO_INCREMENT,
							date date NOT NULL,
							UNIQUE KEY ID (ID)";
				$db->build();
			}

			if (get_option( '_plugin_db_exist') == '0' ) {
				add_action( 'admin_notices', array( $this, 'db_error_msg' ) );
			}

			$options = array(
				array( 'option_name', '__value__' ),
			);
			foreach ( $options as $value ) {
				update_option( $value[0], $value[1] );
			}
		}


		/**
		 * Notice of DB
		 *
		 * @return Html
		 */
		public function db_error_msg() { ?>

			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Database table Not installed correctly.', 'textdomain' ); ?></p>
 			</div>
			<?php
		}


		/**
		 * Uninstall plugin data
		 *
		 * @return Void
		 */
		public function db_uninstall() {

			$table_name = self::$plugin_table;

			global $wpdb;
			$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}$table_name" );

			$options = array(
				'_plugin_db_exist'
			);
			foreach ( $options as $value ) {
				delete_option( $value );
			}
		}


		/**
		 * CRON callback
		 *
		 * @return Void
		 */
		public function do_cron_job_function() {

			//Do cron function
		}


		/**
		 * Run CRON action
		 *
		 * @return Void
		 */
		public function custom_cron_hook_cb() {

			add_action( 'custom_cron_hook', array( $this, 'do_cron_job_function' ) );
		}


		/**
		 * Uninstall CRON hook
		 *
		 * @return Void
		 */
		public function cron_uninstall() {

			wp_clear_scheduled_hook( 'custom_cron_hook' );
		}


		/**
		 * Install Custom post types
		 *
		 * @return Void
		 */
		public function cpt() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Cpt' ) ) new Cpt();
		}


		/**
		 * Include scripts
		 *
		 * @return Void
		 */
		public function scripts() {

			if ( class_exists( 'WPFac\\HostedPage\\Lib\\Script' ) ) new Script();
		}


		/**
		 * Include settings pages
		 *
		 * @return Void
		 */
		public function settings() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Settings' ) ) new Settings();
		}


		/**
		 * Include widget classes
		 *
		 * @return Void
		 */
		public function widgets() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Widget' ) ) new Widget();
		}


		/**
		 *Include metabox classes
		 *
		 * @return Void
		 */
		public function metabox() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Metabox' ) ) new Metabox();
		}


		/**
		 * Include shortcode classes
		 *
		 * @return Void
		 */
		public function shortcode() {

			if ( class_exists( 'WPFac\\HostedPage\\Src\\Shortcode' ) ) new Shortcode();
		}


		/**
		 * Instantiate REST API
		 *
		 * @return Void
		 */
		 public function rest_api() {

			 if ( class_exists( 'WPFac\\HostedPage\\Src\\RestApi' ) ) new RestApi();
		 }


		 /**
 		  * Instantiate REST API
 		  *
 		  * @return Void
 		  */
		 public function prevent_unauthorized_rest_access( $result ) {
 		    // If a previous authentication check was applied,
 		    // pass that result along without modification.
 		    if ( true === $result || is_wp_error( $result ) ) {
 		        return $result;
 		    }

 		    // No authentication has been performed yet.
 		    // Return an error if user is not logged in.
 		    if ( ! is_user_logged_in() ) {
 		        return new WP_Error(
 		            'rest_not_logged_in',
 		            __( 'You are not currently logged in.' ),
 		            array( 'status' => 401 )
 		        );
 		    }

 		    return $result;
 		}


		/**
		 * Instantiate the plugin
		 *
		 * @return Void
		 */
		public function init() {
			//register_activation_hook( PLUGIN_FILE, array( $this, 'db_install' ) );
			//register_activation_hook( PLUGIN_FILE, array( $this, 'cron_activation' ) );
			register_activation_hook( PLUGIN_FILE, array( $this, 'page_install' ) );
			//remove the DB and CORN upon uninstallation
			//using $this won't work here.
			//register_uninstall_hook( PLUGIN_FILE, array( 'WPFac\\HostedPage\\PluginLoader', 'db_uninstall' ) );
			//register_uninstall_hook( PLUGIN_FILE, array( 'WPFac\\HostedPage\\PluginLoader', 'cron_uninstall' ) );
			register_uninstall_hook( PLUGIN_FILE, array( 'WPFac\\HostedPage\\PluginLoader', 'page_uninstall' ) );
			//add_filter( 'rest_authentication_errors', array( $this, 'prevent_unauthorized_rest_access' ) );
			add_action( 'init', array( $this, 'installation' ) );
			add_action( PLUGIN_TEXT_DOMAIN . '_display_payment_button', 'wp_fac_hosted_page_display_payment_button', 10, 1);
        	add_filter( 'rewrite_rules_array',[ $this, 'insert_rewrite_rules'] );
			add_filter( 'query_vars',[ $this, 'insert_query_vars'] );
			$this->custom_cron_hook_cb();
			$this->scripts();
			//$this->widgets();
			//$this->metabox();
			$this->shortcode();
			$this->settings();
			//Alternative method: add_action( 'rest_api_init', array($this, 'rest_api') );
			//$this->rest_api();
		}
    
    	public function rewrite_rules() {
    	
    		$rules = get_option( 'rewrite_rules' );

    		if ( ! isset( $rules[ PLUGIN_TEXT_DOMAIN . '/response/([0-9]{1,})/?'] ) ) {
        		global $wp_rewrite;
        		$wp_rewrite->flush_rules();
    		}
		}

		public function insert_rewrite_rules($rules) 
    	{
        	$newrules = array();
    		$newrules[ PLUGIN_TEXT_DOMAIN . '/response/([0-9]{1,})/?'] = 'index.php?pagename='. PLUGIN_TEXT_DOMAIN .'&transaction_id=$matches[1]';
    		return $newrules + $rules;
    	}

		public function insert_query_vars($vars)
    	{
    		array_push( $vars, 'transaction_id' );
    		return $vars;
    	}
	}
} ?>
