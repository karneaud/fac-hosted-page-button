<?php do_action('fac-hosted-page-button_before_page_error', $transaction_id);  ?>
	<p class="fac_hosted_page_button page_error">Error: <?php print esc_html($code) ?> - <?php print esc_html($message) ?></p>
<?php do_action('fac-hosted-page-button_after_page_error', $transaction_id); ?>