# FAC WP Hosted Pages

Custom plugin for FAC Hosted Pages. Creates a payment button and a custom result page. The plugin is based off of [WP Pluginf Framework](https://github.com/nirjharlo/wp-plugin-framework) 

## Usage
1. Install the plugin 
2. Configure the FAC Hosted Page settings
3. Use short code for payment url button and payment page

## Features

Go through the files in `/lib/class-` and `/src/class-`. First one contains classes for extra features, while the latter is using essential features.

## Notes

Use these hooks for executing additional events

- `do_action('wp-fac-hosted-page_after_page_error', string $transaction_id );` 
- `do_action('wp-fac-hosted-page_after_page_success', string $transaction_id );` 


`/plugin/functions.php` :: Custom helper functions and constants
`/plugin/PluginLoader.php` :: `PluginLoader` class to initialize plugin

### `/plugin/lib` Files

`/plugin/lib/Cron.php` :: `Cron` to schedule operations.

`/plugin/lib/Api.php` :: `Api` to integrate 3rd party APIs.

`/plugin/lib/Table.php` :: `Table` to display data tables.

`/plugin/lib/Ajax.php` :: `Ajax` to make AJAX requests.

`/plugin/lib/Upload.php` :: `Upload` to upload a file.

`/plugin/lib/Script.php` :: `Script` to add required CSS and JS.

`/plugin/lib/Fac.php` :: `Fac` custom class for FAC hosted page methods

### `/plugin/src` Files

`/plugin/src/Install.php` :: `Install` to handle activation process.

`/plugin/src/Db.php` :: `Db` to install database tables.

`/plugin/src/Settings.php` :: `Settings` to create admin settings pages.

`/plugin/src/Cpt.php` :: `Cpt` to create custom post type.

`/plugin/src/Widget.php` :: `Widget` to add custom widget.

`/plugin/src/Metabox.php` :: `Metabox` to add custom metabox in editor screen.

`/plugin/src/Shortcode.php`:: `Shortcode` to add and display shortcodes.

`/plugin/src/Query.php`:: `Query` to use post and user query. It uses `wp_pagenavi()` for breadceumbs

`/plugin/src/RestApi.php`:: `RestApi` to extend REST API.

### `/templates` Template Files

`/templates/part-payment.button.php`:: Template for button
`/templates/part-payment.button.error.php`:: Template error page for button
`/templates/part-payment.success.php`:: Template for result page
`/templates/part-payment.error.php`:: Template for result error page
