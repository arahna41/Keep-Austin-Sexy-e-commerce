<?php
/**
 * Checkout Form
 *
 * @version 3.5.0
 */

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

?>

<?php
if (!defined('ABSPATH')) {
	exit;
}
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20);

?>

<section class="grid_section">
	<div class="section-title">
		<?php woocommerce_breadcrumb(); ?>
		<h1>Checkout</h1>
	</div>

	<div class="order_info order_total">
		<div class="bg"></div>
		<div class="container">

			<div class="order_wrapper">
				<h4 class="order_result_title">Order result</h4>
				<?php do_action('woocommerce_checkout_before_order_review'); ?>
				<?php do_action('woocommerce_checkout_order_review'); ?>
				<?php do_action('woocommerce_checkout_after_order_review'); ?>
			</div>

				<form class="checkout_coupon woocommerce-form-coupon" method="post">
					<p><?php esc_html_e('If you have a coupon code, please apply it below.', 'woocommerce'); ?></p>
					<div class="form_coupon">
						<p class="form-row form-row-first">
							<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" />
						</p>
						<p class="form-row form-row-last">
							<button type="submit" class="button coupon_btn btn_style" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply', 'woocommerce'); ?></button>
						</p>
					</div>
				</form>

				<div class="total_summary">
					<div class="total_list">
						<div class="total_section subtotal">
							<p>Subtotal:</p>
							<span><?php wc_cart_totals_subtotal_html(); ?></span>
						</div>

						<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
							<div class="total_section cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
								<p><?php wc_cart_totals_coupon_label( $coupon ); ?></p>
								<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
							</div>
						<?php endforeach; ?>

						<div class="total_section shipping">
							<p>Shipping:</p>
							<?php $this_order =  wc_get_order(); ?>
							<p class="delivery_message"><?php echo WC()->cart->get_cart_shipping_total() ?><!-- It will be calculated in the next step --></p>
						</div>
						<div class="total_section tax">
							<p>Tax:</p>
							<span><?php wc_cart_totals_taxes_total_html(); ?></span>
						</div>
					</div>

					<div class="total_section checkout_total">
						<p>Total:</p>
						<?php do_action('woocommerce_review_order_before_order_total'); ?>
						<div class="order-total grand">
							<?php wc_cart_totals_order_total_html(); ?>
						</div>
						<?php do_action('woocommerce_review_order_after_order_total'); ?>
					</div>
				</div>
			</div>
		</div>
	

	<form name="checkout" method="post" class="checkout woocommerce-checkout info_side order_list" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
		<div class="container m-0">
			<div class="user_info">
				

				<div class="billing">
					
					<?php if ($checkout->get_checkout_fields()) : ?>
						<?php do_action('woocommerce_checkout_before_customer_details'); ?>

						<div class="contact_info">
							<div class="title_wrapper">
								<h3 class="contact_title text_24">Contact Information</h3>
								<div class="log_in">
									<?php do_action('woocommerce_checkout_login_form'); ?>
								</div>
							</div>
						</div>

						<div class="woocommerce-billing-fields">

							<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

							<div class="delivery_fields woocommerce-billing-fields__field-wrapper">
								<?php
								$fields = $checkout->get_checkout_fields('billing');

								foreach ($fields as $key => $field) {
									$field['label_class'] = ' ';
									woocommerce_form_field($key, $field, $checkout->get_value($key));
								}
								?>
							</div>

							<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
						</div>

						<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
							<div class="woocommerce-account-fields">
								<?php if (!$checkout->is_registration_required()) : ?>

									<p class="form-row form-row-wide create-account">
										<input class="account_checkbox woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
										<label class="text_16 f_w_500 woocommerce-form__label woocommerce-form__label-for-checkbox checkbox checkbox_label" for="createaccount">
											<?php esc_html_e('Create an account?', 'woocommerce'); ?>
										</label>
									</p>

								<?php endif; ?>

								<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

								<?php if ($checkout->get_checkout_fields('account')) : ?>

									<div class="create-account">
										<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
											<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
										<?php endforeach; ?>
										<div class="clear"></div>
									</div>

								<?php endif; ?>

								<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
							</div>
						<?php endif; ?>

						<?php do_action('woocommerce_checkout_after_customer_details'); ?>

					<?php endif; ?>
				</div>

				<?php if ($checkout->get_checkout_fields()) :  ?>
					<?php do_action('woocommerce_checkout_shipping'); ?>
				<?php endif; ?>

				<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
					<?php do_action('woocommerce_review_order_before_shipping'); ?>
					<?php wc_cart_totals_shipping_html(); ?>
					<?php do_action('woocommerce_review_order_after_shipping'); ?>
				<?php endif; ?>

				<div class="payment payment_fields">
					<div class="payment_title_wrap">
						<h3 class="contact_title text_24">Payment</h3>
						<p class="secure_message">All transactions are secure and encrypted.</p>
						<p>Choose a payment method</p>
					</div>
					<?php do_action('woocommerce_checkout_payment'); ?>
					
					<?php
					if (WC()->cart->needs_payment()) {
						$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
						WC()->payment_gateways()->set_current_gateway($available_gateways);
					} else {
						$available_gateways = array();
					}
					$checkout = WC()->checkout();
					$available_gateways = $available_gateways;
					$order_button_text =  apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));
					?>
					<?php
					if (!wp_doing_ajax()) {
						do_action('woocommerce_review_order_before_payment');
					}
					?>
					
				</div>
			</div>

		</div>
		<div class="confirm">
			<?php do_action('woocommerce_review_order_before_submit'); ?>
			<?php $order_button_text = 'Pay'; ?>
			<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button alt btn_style" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine
			?>
			<?php do_action('woocommerce_review_order_after_submit'); ?>
			<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
		</div>
	</form>
		<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
</section>

<script>
	jQuery(document).on('click', '.woocommerce-remove-coupon', function () {
			setTimeout(
					function () {
							window.location.href = window.location.href;
					}, 400);
	});
	jQuery(document).on('click', '.coupon_btn', function () {
			setTimeout(
					function () {
							window.location.href = window.location.href;
					}, 400);
	});
</script>