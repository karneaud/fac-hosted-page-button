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
defined( 'PLUGIN_DEBUG' ) or define( 'PLUGIN_DEBUG', false );

defined( 'PLUGIN_PATH' ) or define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
defined( 'PLUGIN_FILE' ) or define( 'PLUGIN_FILE', plugin_basename( __FILE__ ) );

defined( 'PLUGIN_TRANSLATE' ) or define( 'PLUGIN_TRANSLATE', plugin_basename( plugin_dir_path( __FILE__ ) . 'asset/ln/' ) );

defined( 'PLUGIN_JS' ) or define( 'PLUGIN_JS', plugins_url( '/asset/js/', __FILE__  ) );
defined( 'PLUGIN_CSS' ) or define( 'PLUGIN_CSS', plugins_url( '/asset/css/', __FILE__ ) );
defined( 'PLUGIN_IMAGE' ) or define( 'PLUGIN_IMAGE', plugins_url( '/asset/img/', __FILE__ ) );
defined( 'PLUGIN_TEXT_DOMAIN' ) or define( 'PLUGIN_TEXT_DOMAIN' , 'wp-fac-hosted-page') );

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
