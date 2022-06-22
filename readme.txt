## FAC Hosted Page Button 
Contributors: Kendall Arneaud
Tags: gateway, first atlantic, e-commerce, online, payments, credit card
Author Url: https://kendallarneaud.me/
Version: 1.0.1-beta
Stable Tag: 1.0.1-beta
Requires PHP: 7.4
Tested up to: 6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Custom wordpress plugin to facilitate First Atlantic Commerce hosted page payments 
 
### Description 
 
A custom wordpress plugin developed to facilitate online CC payments using First Atlantic Commerce Hosted Page service. The plugin creates short codes for a payment link button and a hosted page result page for displaying the results on redirect from FAC transaction.
 
### Installation 
 
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin's settings on its settings page.

### Requirements 

* Wordpress > 5.6
* PHP >= 7.4
	- PHP cURL
    - PHP XML
* Merchant Account from First Atlantic Commerce
	- Merchant ID
    - Merchant Pprocessing Password
    - Hosted Payment Page

## Features 

* Customizable template files using theme. Just copy over to theme folder in sub directory called 'fac-hosted-page-button'
    - part-page.error.php
    - part-page.success.php
    - part-payment.button.error.php
    - part-payment.button.php
* Custom actions hooks
    - fac-hosted-page_button_after_page_error
    - fac-hosted-page_button_after_page_success
    - fac-hosted-page_button_before_payment_button
    - fac-hosted-page_button_after_payment_button
    - fac-hosted-page_button_before_payment_button_error
    - fac-hosted-page_button_after_payment_button_error
* Editable Custom Page via Page Section
	- fac-hosted-page_button (slug)
* Shortcodes for response page and payment link button 
    - `[fac-hosted-page_button_payment_button amount="" currency="" transaction_id="" text=""]`
    - `[fac-hosted-page_button_page [page="" message="" transaction_id="" code=""]]`
* Helper functions
    - `fac_hosted_page_button_display_payment_button($attr) `(Displays the button by calling the short code)
* Define overriding constants

## Usage 

Either embed the payment button shortcode into a page/post or call the helper function with parameters similar to the template code. 

E.g. 

#### Payment Link Button 
```
[fac-hosted-page_button_payment_button amount="20.23" currency="BBD" transaction_id="A-9191" text="Pay Now"]
```
#### Custom Results Pages 
```
[fac-hosted-page_button_page ["page"="path/to/template.php" message="Response MEssage" transaction_id="A-9191" code="200"]]
fac_hosted_page_button_display_payment_button(['amount'=>200.34,'currency'=>'JMD',....])
```

### Screenshots
1. Use shortcode in page 
2. Payment Button
3. Default Thank You Page
4. Successful Thank You Page
  
### Changelog 
= 1.0.0-beta =
* Plugin released. 
= 1.0.1-beta =
Security updates 

### Notes 

* You can optionally add hooks for executing additional events on button template and thank you page template
	* `do_action('fac-hosted-page_button_after_page_error', string $transaction_id );` 
	* `do_action('fac-hosted-page_button_after_page_success', string $transaction_id );` 
* A default results page and url is created on install
* Recommend flushing permalinks settings to enable plugin's return response url directives
* Currently, the plugin supports First Atlantic Commerce's 3DS initiatives by default. 
