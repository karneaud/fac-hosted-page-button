=== FAC Hosted Page Button ===
Contributors: Kendall Arneaud
Tags: FAC, first atlantic, ecommerce, online, payments, credit card
Author Url: https://kendallarneaud.me/
Version: 1.0.0
Tested up to: 5.7
Stable tag: 5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Custom wordpress plugin to facilitate First Atlantic Commerce hosted page payments 
 
== Description ==
 
A custom wordpress plugin developed to facilitate online CC payments using First Atlantic Commerce Hosted Page service. The plugin creates short codes for a payment link button and a hosted page result page for displaying the results on redirect from FAC transaction.
 
== Installation ==
 
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin's settings on its settings page.

== Features == 

* Customizable template files using theme. Just copy over to theme folder in sub directory called 'wp-fac-hosted-page-button'
    - part-page.error.php
    - part-page.success.php
    - part-payment.button.error.php
    - part-payment.button.php
* Custom actions hooks
    - wp-fac-hosted-page_button_display_payment_button
    - wp-fac-hosted-page_button_after_page_error
    - wp-fac-hosted-page_button_after_page_success
    - wp-fac-hosted-page_button_before_payment_button
    - wp-fac-hosted-page_button_after_payment_button
    - wp-fac-hosted-page_button_before_payment_button_error
    - wp-fac-hosted-page_button_after_payment_button_error
* Editable Custom Page via Page Section
	- wp-fac-hosted-page_button (slug)
* Shortcodes for response page and payment link button 
    - [wp-fac-hosted-page_button_payment_button amount currency transaction_id text]
    - [wp-fac-hosted-page_button_page [page message transaction_id code]]
* Helper functions
    - wp_fac_hosted_page_button_display_payment_button($attr) (Displays the button by calling the short code)
* Define overriding constants

== Usage ==

Either embed the payment button shortcode into a page/post or call the helper function with parameters in template code. 

== Notes ==

You will need to add hooks for executing additional events

* `do_action('wp-fac-hosted-page_button_after_page_error', string $transaction_id );` 
* `do_action('wp-fac-hosted-page_button_after_page_success', string $transaction_id );` 
* A default results page and url is created  on install
* Recommend flushing permalinks settings to enable plugin's return response url directives
