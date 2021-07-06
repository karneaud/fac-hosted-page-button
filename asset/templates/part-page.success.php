<?php do_action('wp-fac-hosted-page_before_page_success', $data['transaction_id']); ?>
	<h3>Payment Processed Successfully</h3>
	<p>Transaction Reference #<?php print $data['transaction_id'] ?></p>
	<p class="wp_fac_hosted_page page_success_messasge"><?php print $data['message']; ?></p>
<?php do_action('wp-fac-hosted-page_after_page_success', $data['transaction_id'] ); ?>