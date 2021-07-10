=== FAC Hosted Page ===
Contributors: Kendall Arneaud
Tags: FAC, first atlantic, ecommerce, online, payments, credit card
Author Url: https://kendallarneaud.me/
Tested up to: 5.7
Stable tag: 5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Custom wordpress plugin to facilitate First Atlantic Commerce hosted page payments 
 
== Description ==
 
A custom wordpress plugin developed to facilitate online CC payments using First Atlantic Commerce. The plugin creates short codes for a payment link button and a hosted page result page for displaying the results on redirect from FAC transaction.
 
== Installation ==
 
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin's settings on its settings page.

== Features == 

* Customizable template files using theme. Just copy over to theme folder in sub directory called 'wp-fac-hosted-page'
* Custom actions hooks
* Editable Custom Page via Page Section
* Shortcodes for response page and payment link button
* Helper functions
* Define overriding constants

== Notes ==

You will need to add hooks for executing additional events

* `do_action('wp-fac-hosted-page_after_page_error', string $transaction_id );` 
* `do_action('wp-fac-hosted-page_after_page_success', string $transaction_id );` 
