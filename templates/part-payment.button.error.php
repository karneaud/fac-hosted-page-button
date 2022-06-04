<?php do_action(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_before_payment_button_error');?>
<p class="fac_hosted_page payment_button_error">Error: <?php print esc_html($code) ?> - <?php print esc_html($message) ?></p>
<?php do_action(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_after_payment_button_error');?>