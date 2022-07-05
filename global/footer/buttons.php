<?php
/**
 * Footer Buttons
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/footer/buttons.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 3.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


extract( Xoo_Wsc_Template_Args::footer_buttons() );

do_action( 'xoo_wsc_before_footer_btns' );

$buttonHTML = '<a href="%1$s" class="%2$s">%3$s</a>';

?>
<div class="xoo-wsc-ft-buttons-cont">

<a href="#" class="xoo-wsc-ft-btn button btn xoo-wsc-cart-close xoo-wsc-ft-btn-continue">
	Сontinue shopping
</a>

<a href="<?php echo wc_get_checkout_url(); ?>">
	Сheckout
</a>

</div>

<?php do_action( 'xoo_wsc_after_footer_btns' ); ?>

<div class="xoo-wsc-payment-btns">
	<?php do_action( 'xoo_wsc_payment_buttons' ); ?>
</div>