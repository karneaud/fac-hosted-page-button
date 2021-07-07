<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_before_payment_button_error');?>
<p class="wp_fac_hosted_page payment_button_error">Error: <?php print $data['code'] ?> - <?php print $data['message'] ?></p>
<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_after_payment_button_error');?>