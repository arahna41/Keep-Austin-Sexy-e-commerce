<?php
/**
 * Footer Extras
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/footer/extras.php.
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

extract( Xoo_Wsc_Template_Args::footer_extras() );

?>

<?php

//Empty cart link
if( $emptyCartLink && !WC()->cart->is_empty() ){
	echo '<span class="xoo-wsc-ecl">'.get_field('clean_bag','option').'</span>';
}

?>

<div class="xoo-wsc-ft-extras">

	<?php if( $showCoupon && !WC()->cart->is_empty() ): ?>



	<?php endif; ?>

	<?php do_action( 'xoo_wsc_extras_content' ); ?>

</div>