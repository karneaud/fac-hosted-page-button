<?php
/**
 Plugin Name: FAC Hosted Pages WordPress Plugin
 Plugin URI: https://github.com/nirjharlo/wp-plugin-framework/
 Description: Custom FAC hosted pages plugin for Wordpress
 Version: 1.0.0
 Author: Kendall Arneaud
 Author URI: https://kendallarneaud.me
 Text Domain: wp-fac-hosted-page
 Domain Path: /asset/ln
 License: GPLv2
 License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit;


//Define basic names
//Edit the "_PLUGIN" in following namespaces for compatibility with your desired name.
defined( 'WP_FAC_HOSTED_PAGE_DEBUG' ) or define( 'WP_FAC_HOSTED_PAGE_DEBUG', false );
defined( 'WP_FAC_HOSTED_PAGE_PATH' ) or define( 'WP_FAC_HOSTED_PAGE_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WP_FAC_HOSTED_PAGE_FILE' ) or define( 'WP_FAC_HOSTED_PAGE_FILE', plugin_basename( __FILE__ ) );
defined( 'WP_FAC_HOSTED_PAGE_TRANSLATE' ) or define( 'WP_FAC_HOSTED_PAGE_TRANSLATE', plugin_basename( plugin_dir_path( __FILE__ ) . 'asset/ln/' ) );
defined( 'WP_FAC_HOSTED_PAGE_TEMPLATE' ) or define( 'WP_FAC_HOSTED_PAGE_TEMPLATE', plugin_dir_path(  __FILE__  )  . 'templates' );
defined( 'WP_FAC_HOSTED_PAGE_JS' ) or define( 'WP_FAC_HOSTED_PAGE_JS', plugins_url( '/assets/js/', __FILE__  ) );
defined( 'WP_FAC_HOSTED_PAGE_CSS' ) or define( 'WP_FAC_HOSTED_PAGE_CSS', plugins_url( '/assets/css/', __FILE__ ) );
defined( 'WP_FAC_HOSTED_PAGE_IMAGE' ) or define( 'WP_FAC_HOSTED_PAGE_IMAGE', plugins_url( '/assets/img/', __FILE__ ) );
defined( 'WP_FAC_HOSTED_PAGE_TEXT_DOMAIN' ) or define( 'WP_FAC_HOSTED_PAGE_TEXT_DOMAIN' , 'wp-fac-hosted-page') ;
defined( 'WP_FAC_HOSTED_PAGE_MERCHANT_ID' ) or define( 'WP_FAC_HOSTED_PAGE_MERCHANT_ID' , get_option( WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_settings' )['merchant_id'] ?? '123456') ;
defined( 'WP_FAC_HOSTED_PAGE_MERCHANT_PASSWD' ) or define( 'WP_FAC_HOSTED_PAGE_MERCHANT_PASSWD' , get_option( WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_settings' )['merchant_secret'] ?? 'abcdefg') ;
defined( 'WP_FAC_HOSTED_PAGE_PAGE_SET' ) or define( 'WP_FAC_HOSTED_PAGE_PAGE_SET' , get_option( WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_settings' )['page_set'] ?? 'test1') ;
defined( 'WP_FAC_HOSTED_PAGE_PAGE_NAME' ) or define( 'WP_FAC_HOSTED_PAGE_PAGE_NAME' , get_option( WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_settings' )['page_name'] ?? 'test') ;
defined( 'WP_FAC_HOSTED_PAGE_TEST_MODE' ) or define( 'WP_FAC_HOSTED_PAGE_TEST_MODE' , get_option( WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_settings' )['test_mode'] ?? false ) ;
//The Plugin
require_once( 'vendor/autoload.php' );
require_once('plugin/functions.php');

function plugin() {
	if ( class_exists( 'WPFac\\HostedPage\\PluginLoader' ) ) {
		return WPFac\HostedPage\PluginLoader::instance();
	}
}

global $plugin;
$plugin = plugin(); ?>
