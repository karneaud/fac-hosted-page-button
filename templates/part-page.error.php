<?php do_action('wp-fac-hosted-page-button_before_page_error', $transaction_id);  ?>
	<p class="wp_fac_hosted_page page_error">Error: <?php print $code ?> - <?php print $message ?></p>
<?php do_action('wp-fac-hosted-page-button_after_page_error', $transaction_id); ?>