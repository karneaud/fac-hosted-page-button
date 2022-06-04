<?php do_action(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_before_page_success', $transaction_id); ?>
	<h3>Payment Processed Successfully</h3>
	<p>Transaction Reference #<?php print $transaction_id ?></p>
	<p class="fac_hosted_page page_success_messasge"><?php print esc_html($message); ?></p>
<?php do_action(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_after_page_success', $transaction_id ); ?>