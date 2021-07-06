<?php do_action('wp-fac-hosted-page_before_page_error', $data['transaction_id']);  ?>
	<p class="wp_fac_hosted_page page_error">Error: <?php print $data['code'] ?> - <?php print $data['message'] ?></p>
<?php do_action('wp-fac-hosted-page_after_page_error', $data['transaction_id']); ?>