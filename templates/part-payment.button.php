<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_before_payment_button');?>
<form method="GET" class="wp_fac_hosted_page payment_link" id="fac_hosted_page_form" action="<?php print $fac_hosted_page_url ?>">
	<button type="submit" form="fac_hosted_page_form" value="Submit" class="wp_fac_hosted_page payment_button">
    <?php print $text ?></button>
</form>
<?php do_action(WP_FAC_HOSTED_PAGE_TEXT_DOMAIN . '_after_payment_button');?>