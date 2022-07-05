<?php get_header(); ?>

  <main>

      <section class="banner">
        <div class="carousel main_page_banner__carousel">

        <?php
        if( get_field('banners' ) ){
            $count = 1;
            while ( has_sub_field('banners' ) ) :
        ?>
            <?php if( get_row_layout() == 'banner' ){?>

              <div class="main_page__slide_1 carousel__slide">
                <img data-lazy-src="<?php the_sub_field('img'); ?>" />
                <div class="main_page__banner_description_right">
                  <?php $product   = wc_get_product(get_sub_field('product_banner')); ?>
                  <?php $category =  get_sub_field('category'); ?>
                  <h4><?php echo get_the_title(get_sub_field('product_banner')); ?></h4>
                  <p class="main_page__banner_category text_16"><?php echo get_the_category_by_ID($category);?></p>
                  <p class="main_price">$<?php echo $product->get_price() ?></p>
                </div>
              </div>
              <div class="main_page_banner__text_container">
                <div class="main_page__banner_description_left">
                  <p class="main_page__banner_category"><?php echo get_cat_name(get_sub_field('category'));?></p>
                  <h3> <?php the_sub_field('title'); ?></h3>
                  <p class="main_page__banner_text">
                    <?php the_sub_field('desc'); ?>
                  </p>
                  <a class="btn_style text_12 font_btn" href="<?php echo get_category_link(get_sub_field('category'));?>" >Shop Now</a>
                </div>
              </div>

            <?php }?>
        <?php
            $count = $count++;
            endwhile;
        }?>
        </div>
      </section>

      <section class="main_page__categories_block">
        <div class="container">
          <h2 class="text_32">Categories</h2>
          <div class="main_page__categories_mobile">

							<?php
							$taxonomy     = 'product_cat';
							$orderby      = 'name';
							$show_count   = 0;      // 1 for yes, 0 for no
							$pad_counts   = 0;      // 1 for yes, 0 for no
							$hierarchical = 1;      // 1 for yes, 0 for no
							$title        = '';
							$empty        = 0;
							$args = array(
									'taxonomy'     => $taxonomy,
									'orderby'      => $orderby,
									'show_count'   => $show_count,
									'pad_counts'   => $pad_counts,
									'hierarchical' => $hierarchical,
									'title_li'     => $title,
									'hide_empty'   => $empty
							);
							$all_categories = get_categories( $args );
							foreach ($all_categories as $cat) {
								if($cat->category_parent == 0 && $cat->category_count != 0 ) {

									$category_id = $cat->term_id;
                  $cat_link = get_category_link( $category_id );
                  $image_url = wp_get_attachment_image( $category_id );

                  $thumbnail_id = get_woocommerce_term_meta( $category_id, 'thumbnail_id', true );
                  $cat_image = wp_get_attachment_url( $thumbnail_id );
            ?>

                <div class="main_page__category_item">
                  <img src="<?php echo $cat_image; ?>" alt="<?php echo $cat->name; ?>" />
                  <div class="main_page__category_text">
                    <h4 class="main_page__category_title"><?php echo $cat->name; ?></h4>
                    <a href="<?php echo $cat_link; ?>" class="link">Shop now</a>
                  </div>
                </div>

              <?php
								}
							}
							?>

          </div>

          <div class="carousel main_page__categories_desktop">

							<?php
							$taxonomy     = 'product_cat';
							$orderby      = 'name';
							$show_count   = 0;      // 1 for yes, 0 for no
							$pad_counts   = 0;      // 1 for yes, 0 for no
							$hierarchical = 1;      // 1 for yes, 0 for no
							$title        = '';
							$empty        = 0;
							$args = array(
									'taxonomy'     => $taxonomy,
									'orderby'      => $orderby,
									'show_count'   => $show_count,
									'pad_counts'   => $pad_counts,
									'hierarchical' => $hierarchical,
									'title_li'     => $title,
									'hide_empty'   => $empty
							);
							$all_categories = get_categories( $args );
							foreach ($all_categories as $cat) {
								if($cat->category_parent == 0 && $cat->category_count != 0 ) {

									$category_id = $cat->term_id;
                  $cat_link = get_category_link( $category_id );
                  $image_url = wp_get_attachment_image( $category_id );

                  $thumbnail_id = get_woocommerce_term_meta( $category_id, 'thumbnail_id', true );
                  $cat_image = wp_get_attachment_url( $thumbnail_id );
            ?>

              <div class="main_page__category_item carousel__slide">
                <img src="<?php echo $cat_image; ?>" alt="<?php echo $cat->name; ?>" />
                <div class="main_page__category_text">
                  <h4 class="main_page__category_title"><?php echo $cat->name; ?></h4>
                  <a href="<?php echo $cat_link; ?>" class="link">Shop now</a>
                </div>
              </div>

              <?php
								}
							}
							?>

          </div>
        </div>
      </section>

      <?php
        $id = get_field('product_promo');
        $product   = wc_get_product( $id);
        $post_thumbnail_id = $product->get_image_id();
      ?>

      <section class="main_page__promo">
        <div class="container">
          <div class="main_page__promo_text">
            <p class="text_16">
                <?php
                $catTerms = get_the_terms( $id, 'product_cat' );
                foreach($catTerms as $category) {
                  echo  $category->name;
                }
                ?>
            </p>
            <h3 class="text_48"><?php echo $product->get_title(); ?></h3>
            <p class="main_price">$ <?php echo $product->get_price() ?> </p>
            <p class="text_16">
              <?php
              echo $product->get_description();
              ?>
            </p>
          </div>
          <div class="main_page__promo_carousel carousel">

          <?php
          $attachment_ids = $product->get_gallery_attachment_ids();
          array_unshift($attachment_ids, $post_thumbnail_id);
          foreach( $attachment_ids as $attachment_id ) { ?>
            <div class="carousel__slide">
              <img src="<?php echo wp_get_attachment_url($attachment_id);?>" alt="" />
            </div>
          <?php }
          ?>
          </div>

        <div class="summary entry-summary">
          <?php
          /**
           * Hook: woocommerce_single_product_summary.
           *
           * @hooked woocommerce_template_single_title - 5
           * @hooked woocommerce_template_single_rating - 10
           * @hooked woocommerce_template_single_price - 10
           * @hooked woocommerce_template_single_excerpt - 20
           * @hooked woocommerce_template_single_add_to_cart - 30
           * @hooked woocommerce_template_single_meta - 40
           * @hooked woocommerce_template_single_sharing - 50
           * @hooked WC_Structured_Data::generate_product_data() - 60
           */
          do_action( 'woocommerce_single_product_summary' );
          ?>
        </div>

          <div class="main_page__promo_images">
            <div class="promo_image__main_photo">
              <img src="<?php echo get_the_post_thumbnail_url($product->id);?>" alt="<?php echo $product->get_title(); ?>" />
            </div>

            <div class="promo_image__thumbnail">
          <?php
          $attachment_ids = $product->get_gallery_attachment_ids();
          foreach( $attachment_ids as $attachment_id ) { ?>
              <img src="<?php echo wp_get_attachment_url($attachment_id);?>" alt="<?php echo $product->get_title(); ?>" />
          <?php }
          ?>
            </div>
          </div>
        </div>
      </section>

      <section class="main_page__showcase">
        <div class="container">
          <h2 class="text_32">Everyday clothes</h2>
          <div class="main_page__showcase_carousel carousel">


              <?php
              $categories = get_field('categories');
              if( $categories ) { ?>

                <?php foreach( $categories as $cat ){?>
                <?php
									$category_id = $cat;
                  $cat_link = get_category_link( $category_id );
                  $image_url = wp_get_attachment_image( $category_id );

                  $thumbnail_id = get_woocommerce_term_meta( $category_id, 'thumbnail_id', true );
                  $cat_image = wp_get_attachment_url( $thumbnail_id );
                  ?>

                <div class="main_page__showcase_item carousel__slide">
                  <div class="showcase_parent_img">
                    <img src="<?php echo $cat_image; ?>" alt="<?php echo get_the_category_by_ID($category_id);?>" />
                  </div>
                  <div class="main_page__showcase_text">
                    <h4 class="main_page__showcase_title"><?php echo get_the_category_by_ID($category_id);?></h4>
                    <a href="<?php echo $cat_link; ?>" class="link">Go shopping</a>
                  </div>
                </div>

              <?php } ?>

              <?php
              wp_reset_postdata(); ?>
            <?php } ?>
          </div>
        </div>
      </section>

      <section class="main_page__sertificates">
        <div class="container">
          <div class="main_page__sertificate_item sertificates__gift">
            <div class="sertificates_parent"></div>
            <div class="gift_sertificates__text">
              <h4><?php the_field('setificates_title_1'); ?></h4>
              <p>
                <?php the_field('setificates_desc_1'); ?>
              </p>
              <a href="<?php the_field('setificates_link_1'); ?>" class="link"><?php the_field('setificates_link_name_1'); ?></a>
            </div>
          </div>
          <div class="main_page__sertificate_item sertificates__shipping">
            <div class="sertificates_parent"></div>
            <div class="gift_sertificates__text">
              <h4><?php the_field('setificates_title_2'); ?></h4>
              <p>
                <?php the_field('setificates_desc_2'); ?>
              </p>
              <a href="<?php the_field('setificates_link_2'); ?>" class="link"><?php the_field('setificates_link_name_2'); ?></a>
            </div>
          </div>
        </div>
      </section>

      <section class="main_page__popular_products main_page__showcase">
        <div class="container">
          <h2 class="text_32">Popular products</h2>
          <div class="main_page__showcase_carousel carousel">

            <?php
                global $product;
                global $paged;
                $count = 1;
                if (get_query_var( 'paged' ))
                $my_page = get_query_var( 'paged' );
                else {
                if( get_query_var( 'page' ) )
                  $my_page = get_query_var( 'page' );
                else
                  $my_page = 1;
                set_query_var( 'paged', $my_page );
                $paged = $my_page;
                }
                $args = array(
                  'post_type'      => 'product',
                  'posts_per_page' => 16,
                  'meta_key' => 'total_sales',
                  'orderby' => 'meta_value_num',
                  'paged'    => $my_page,
                  'order'          => 'DESC',
                );
                $my_query = new WP_Query( $args );
                while ($my_query->have_posts()) : $my_query->the_post();
                ?>

          <?php
            global $product;
            $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
          ?>
            <div class="main_page__showcase_item carousel__slide <?php echo $count; ?>">
              <div class="showcase_parent_img">
                <?php
                $id = $product->get_id();
                $product   = wc_get_product( $id);
                $image_id  = $product->get_image_id();
                $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                ?>
                <img src="<?php echo $image_url; ?>"  alt="<?php the_title(); ?>" />
              </div>
              <div class="main_page__showcase_text">
                <h5 class="text_18 h5_product"><?php the_title(); ?></h5>
                <p class="price text_18">$ <?php echo $product->get_price() ?></p>
              </div>
            </div>
            <?php $count++; ?>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
          </div>
        </div>
      </section>

      <section class="main_page__blog">
        <div class="container">
          <h2 class="text_32 main_page__blog_title">Blog</h2>
          <div class="main_page__blog_carousel carousel">

            <?php
            global $paged;
            if (get_query_var( 'paged' ))
                  $my_page = get_query_var( 'paged' );
            else {
                  if( get_query_var( 'page' ) )
                      $my_page = get_query_var( 'page' );
                  else
                      $my_page = 1;
                  set_query_var( 'paged', $my_page );
                  $paged = $my_page;
            }
            $args = array(
                'post_type' => array('post'),
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 12,
                'post_status' => 'publish',
            );
            $my_query = new WP_Query( $args );
            while ($my_query->have_posts()) : $my_query->the_post();
            ?>

            <div class="main_page__blog_item carousel__slide">
              <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title();?>" />
              <div class="main_page__blog_text">
                <h4 class="text_24"><?php the_title();?></h4>
                <p>
                  <?php  echo wp_trim_words( get_the_content(), 8, ' ...' ); ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="link">Read more</a>
              </div>
            </div>

            <?php
                endwhile;
                  wp_reset_query();
                ?>

          </div>
          <a class="btn_secondary main_page_blog_btn" href="<?php echo get_the_permalink(730); ?>">
            See more articles
          </a>
        </div>
      </section>

      <section class="main_page__adress">
        <div class="container">
          <div class="main_page__adress_text">
            <h2 class="text_32">Shop</h2>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu
              pellentesque nulla volutpat eget fames. Sagittis, malesuada
              fringilla donec etiam aliquam. Arcu non enim in arcu, integer
              morbi varius eget curabitur.
            </p>
            <a
              class="btn_style"
              href="https://maps.google.com/maps/dir//Whole+Foods+Market+525+N+Lamar+Blvd+Austin,+TX+78703+%D0%A1%D0%BE%D0%B5%D0%B4%D0%B8%D0%BD%D0%B5%D0%BD%D0%BD%D1%8B%D0%B5+%D0%A8%D1%82%D0%B0%D1%82%D1%8B/@30.2706339,-97.753587,13z/data=!4m5!4m4!1m0!1m2!1m1!1s0x8644b5121409947f:0xedd0593f67f1378e"
              >View on the map</a
            >
          </div>
          <div class="map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13783.709197769726!2d-97.76544426277124!3d30.267652564398364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8644b5121409947f%3A0xedd0593f67f1378e!2sWhole%20Foods%20Market!5e0!3m2!1sru!2sua!4v1646742771372!5m2!1sru!2sua"
              width="600"
              height="450"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
            ></iframe>
            <div class="main_page__contacts">
              <h2 class="text_32">Contacts</h2>
              <p>Our clothes can now be purchased in the store</p>
              <div class="main_page__contacts_links">
                <a href="<?php the_field('map_link', 'option'); ?>" class="contacts__adress"	><?php the_field('adress', 'option'); ?></a>
                <a href="tel:<?php the_field('phone', 'option'); ?>" class="contacts__phone"><?php the_field('phone', 'option'); ?></a>
                <a href="mail:<?php the_field('mail', 'option'); ?>" class="contacts__email"><?php the_field('mail', 'option'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </section>

  </main>

<?php

get_footer();

?>