<?php do_action(WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_before_page_success', $transaction_id); ?>
	<h3>Payment Processed Successfully</h3>
	<p>Transaction Reference #<?php print $transaction_id ?></p>
	<p class="wp_fac_hosted_page page_success_messasge"><?php print $message; ?></p>
<?php do_action(WP_FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_after_page_success', $transaction_id ); ?>