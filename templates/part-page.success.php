<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_before_page_success', $data['transaction_id']); ?>
	<h3>Payment Processed Successfully</h3>
	<p>Transaction Reference #<?php print $data['transaction_id'] ?></p>
	<p class="wp_fac_hosted_page page_success_messasge"><?php print $data['message']; ?></p>
<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_after_page_success', $data['transaction_id'] ); ?>