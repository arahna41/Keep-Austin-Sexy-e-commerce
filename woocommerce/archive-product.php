<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

?>
<main>
  <section class="catalog__banner">
    <h1 class="catalog__banner_title text_32"><?php woocommerce_page_title(); ?></h1>
  </section>

  <section class="products">
    <?php
    if ( woocommerce_product_loop() ) {
    ?>
    <?php
      ob_start();
      wc_set_loop_prop( 'loop', 0 );
      $loop_start = apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );
      ?>

      <?php woocommerce_breadcrumb(); ?>

      <div class="container">
        <div class="catalog_filters">
          <?php echo do_shortcode( '[yith_wcan_mobile_modal_opener]' ); ?>
          <div class="catalog_overlay">
            <div class="catalog_filters_panel">
              <?php echo do_shortcode( '[yith_wcan_filters slug="default-preset"]' ); ?>
              <button class="btn_catalog_filters_cross"></button>
            </div>
          </div>
        </div>

        <div class="catalog_sort">
          <?php
              $total = wc_get_loop_prop( 'total' );
              $per_page =  wc_get_loop_prop( 'per_page' );
              $current = wc_get_loop_prop( 'current_page' );
          ?>
          <p class="catalog_filters__count catalog_filters__count_desktop">
            <?php
            // phpcs:disable WordPress.Security
            if ( 1 === intval( $total ) ) {
              _e( 'Showing the single result', 'woocommerce' );
            } elseif ( $total <= $per_page || -1 === $per_page ) {
              /* translators: %d: total results */
              printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'woocommerce' ), $total );
            } else {
              $first = ( $per_page * $current ) - $per_page + 1;
              $last  = min( $total, $per_page * $current );
              /* translators: 1: first result 2: last result 3: total results */
              printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
            }
            // phpcs:enable WordPress.Security
            ?>
          </p>

          <div class="catalog_sort_dropdown">
            <h4 class="catalog_sort_dropdown_title h4_upper_700">Sort by:</h4>

            <?php

                if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
                  return;
                }
                $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
                $catalog_orderby_options = apply_filters(
                  'woocommerce_catalog_orderby',
                  array(
                    'menu_order' => __( 'Default sorting', 'woocommerce' ),
                    'popularity' => __( 'Sort by popularity', 'woocommerce' ),
                    'rating'     => __( 'Sort by average rating', 'woocommerce' ),
                    'date'       => __( 'Sort by latest', 'woocommerce' ),
                    'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
                    'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
                  )
                );

                $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
                // phpcs:disable WordPress.Security.NonceVerification.Recommended
                $orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;
                // phpcs:enable WordPress.Security.NonceVerification.Recommended

                if ( wc_get_loop_prop( 'is_search' ) ) {
                  $catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );

                  unset( $catalog_orderby_options['menu_order'] );
                }

                if ( ! $show_default_orderby ) {
                  unset( $catalog_orderby_options['menu_order'] );
                }

                if ( ! wc_review_ratings_enabled() ) {
                  unset( $catalog_orderby_options['rating'] );
                }

                if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
                  $orderby = current( array_keys( $catalog_orderby_options ) );
                }

              ?>

            <form class="woocommerce-ordering" method="get">
              <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
                <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                  <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="paged" value="1" />
              <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
            </form>

          </div>
        </div>

        <div class="products__container">
          <?php 
            $attrColor = $_GET['filter_color']; 
            $attrSize = $_GET['filter_sizes']; 
          ?>
          
          <div class="product_cat_parent">

            <?php
              if ( wc_get_loop_prop( 'total' ) ) {
              while ( have_posts() ) {
                the_post();
                //wc_get_template_part( 'content', 'product' );
                global $product;
                $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
            ?>

                <div class="product_cat">
              
                  <a href="<?php echo esc_url( $link ) . '?attribute_pa_color=' . $attrColor . '&attribute_pa_sizes=' . $attrSize; ?>">
                    <?php
                    $id = $product->get_id();
                    $product   = wc_get_product( $id);
                    $image_id  = $product->get_image_id();
                    $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                    ?>
                    <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>"/>
                  </a>
                  <div class="catalog_text">

                  <a href="<?php echo esc_url( $link ) . '?attribute_pa_color=' . $attrColor . '&attribute_pa_sizes=' . $attrSize; ?>" class="text_18 h5_product">
                    <?php echo get_the_title(); ?>
                  </a>
                  <p class="price text_18">$ <?php echo $product->get_price() ?></p>
                  </div>
                </div>

            <?php
                  }
                }
              ?>

          </div>

        <!-- pagination -->
          <div class="woocommerce_after_shop_loop">
            <?php
              do_action( 'woocommerce_after_shop_loop' );
            ?>
          </div>
        <!-- /pagination -->

        </div>

      </div>

      <?php
        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        //do_action( 'woocommerce_after_shop_loop' );
      ?>

    <?php
    } else {
    ?>
      <div class="woocommerce_no_products_found">
        <?php
          do_action( 'woocommerce_no_products_found' );
        ?>
      </div>
    <?php
    }?>

  </section>
</main>

<?php
get_footer( 'shop' );
?>
