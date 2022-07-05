<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
/* do_action( 'woocommerce_cart_is_empty' ); */

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<section class="cart_empty order_page container">
    <div class="section-title">
      <?php woocommerce_breadcrumb(); ?>
      <h1 class="text_32">Shopping Cart</h1>
      <p class="empty_text">Your shopping cart is empty.</p>
      <a class="go_shopping_btn btn_style" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
        <?php
        /**
         * Filter "Return To Shop" text.
         *
         * @since 4.6.0
         * @param string $default_text Default text.
         */
        echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Go shopping', 'woocommerce')));
        ?>
      </a>
    </div>
  </section>
<?php endif; ?>



