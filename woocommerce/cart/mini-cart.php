<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<h2 class="h4 mini_cart__title">Shopping cart</h2>
<span class="mini_cart__close"></span>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="mini_cart__content">

		<div class="cart_order mini_cart_order">
        <?php
          foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
          ?>
              <div class="checkout_product <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
        
                <a class="product_img" href="<?php the_permalink($_product->id); ?>">
                  <img src="<?php echo get_the_post_thumbnail_url($_product->id); ?>" alt="<?php echo $_product->get_title(); ?>">
                </a>
        
                <a class="title" href="<?php the_permalink($_product->id); ?>">
                  <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
                </a>
        
        
                <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                  <?php
                  echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                  ?>
                </div>
        
                <div class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                  <?php
                  if ($_product->is_sold_individually()) {
                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                  } else {
                    $product_quantity = woocommerce_quantity_input(
                      array(
                        'input_name'   => "cart[{$cart_item_key}][qty]",
                        'input_value'  => $cart_item['quantity'],
                        'max_value'    => $_product->get_max_purchase_quantity(),
                        'min_value'    => '0',
                        'product_name' => $_product->get_name(),
                      ),
                      $_product,
                      false
                    );
                  }
                  echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                  ?>
                </div>
        
                <div class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                  <?php
                  echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                  ?>
                </div>
                <div class="delete_product">
                  <div class="product-remove">
                    <?php
                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                      'woocommerce_cart_item_remove_link',
                      sprintf(
                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                        esc_html__('Remove this item', 'woocommerce'),
                        esc_attr($product_id),
                        esc_attr($_product->get_sku())
                      ),
                      $cart_item_key
                    );
                    ?>
                  </div>
                </div>
              </div>
          <?php
            }
          }
        ?>
				
      </div>


		<p class="woocommerce-mini-cart__total total">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="woocommerce-mini-cart__buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

	</div>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
