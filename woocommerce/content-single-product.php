<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}
?>
  <?php if ($product->get_type() == 'wgm_gift_card') { ?>
    <section id="product-<?php the_ID(); ?>" class="gift_card_main">
      <div class="gift_card__images">
        <img src="<?php echo wp_get_attachment_url($product->get_image_id());?>" alt="<?php echo $product->get_name(); ?>"/>
      </div>

      <div class="gift_card__description">
        <span class="gift_card_desc__cross"></span>

        <h4 class="text_24"><?php the_title(); ?></h4>

        <div class="product_page__attributes gift_card__attributes">
          <?php
            $product_type = $product->get_type();
          ?>

          <?php do_action( 'woocommerce_'.$product_type.'_add_to_cart' ); ?>

        </div>
      </div>
  </section>
  <?php } else { ?>
    <main  id="product-<?php the_ID(); ?>"    <?php wc_product_class( 'product_page__main', $product ); ?> >

        <?php woocommerce_breadcrumb(); ?>

        <section class="product_page__product">

          <div class="product_page__images">

            <?php
            /**
               * Hook: woocommerce_before_single_product_summary.
               *
               * @hooked woocommerce_show_product_sale_flash - 10
               * @hooked woocommerce_show_product_images - 20
               */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>

          </div>

          <div class="product_page__description">

            <h4 class="text_24"><?php the_title(); ?></h4>
            <p class="product_page__price text_24 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
              <?php echo $product->get_price_html(); ?>
            </p>
            <div class="product_page__attributes">
              <?php
                $product_type = $product->get_type();
              ?>

              <?php do_action( 'woocommerce_'.$product_type.'_add_to_cart' ); ?>

            </div>
            <div class="product_page__web_description">
              <h4 class="text_16 h4_upper_500">Description</h4>

              <?php the_content(); ?>

            </div>
          </div>
          <div class="product_page__reviews">
            <?php echo comments_template(); ?>
          </div>
        </section>

        <section class="product_page__recomended_products">
          <h2 class="recomended_products__title">
            Recommended products
          </h2>

            <?php $related_products = wc_get_related_products( $product_id, $limit, $exclude_ids ); ?>

          <div class="main_page__showcase_carousel carousel">

            <?php foreach ( $related_products as $related_product ) : ?>
              <?php
              $product   = wc_get_product($related_product);
              $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink($related_product), $product );
              ?>

            <div class="main_page__showcase_item  carousel__slide">
              <a class="related_products_parent_img" href="<?php echo esc_url( $link ); ?>">
                <?php
                $image_id  = $product->get_image_id();
                $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                ?>
                <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>"/>
              </a>
              <div class="main_page__showcase_text">
                <h5 class="text_18 h5_product">
                  <a href="<?php echo esc_url( $link ); ?>">
                    <?php echo $product->get_name(); ?>
                  </a>
                </h5>
                <p class="product_page_price text_18">$ <?php echo $product->get_price() ?></p>
              </div>
          </div>

          <?php endforeach; ?>
          <?php
            wp_reset_query();
          ?>
      </section>
    </main>
  <?php } ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>