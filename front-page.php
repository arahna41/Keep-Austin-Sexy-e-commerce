<?php get_header(); ?>

  <main>

      <section class="banner">
        <div class="carousel main_page_banner__carousel">

          <?php
              $banner_posts = get_posts( array(
                'numberposts' => -1,
                'category_name'    => 'banner',
                'orderby'     => 'date',
                'order'       => 'ASC',
                'post_type'   => 'post',
                'suppress_filters' => true,
              ) );

              foreach( $banner_posts as $banner_post ){
                setup_postdata( $banner_post );
                ?>
                  <div class="main_page__slide_1 carousel__slide 123">
                  <?php $banner_image = wp_get_attachment_image_src( get_post_thumbnail_id( $banner_post->ID ), 'single-post-thumbnail' );
                    $banner_term = get_field('banners_category_product', $banner_post->ID);
                  ?>             
                    <img src="<?php echo $banner_image[0]; ?>" alt="<?php the_title(); ?>">
                    <div class="main_page__banner_description_left">
                      <p class="main_page__banner_category"><?php echo esc_html( $banner_term->name ); ?></p>
                      <h3><?php the_title(); ?></h3>
                      <p class="main_page__banner_text">
                        <?php the_content(); ?>
                      </p>
                      <a class="btn_style" href="<?php echo esc_url( get_term_link( $banner_term ) ); ?>" >Shop Now</a>
                    </div>
                  </div>
                <?php
              }

              wp_reset_postdata(); 
            ?>
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
                  'exclude' => '52',
									'show_count'   => $show_count,
									'pad_counts'   => $pad_counts,
									'hierarchical' => $hierarchical,
									'title_li'     => $title,
									'hide_empty'   => $empty,
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

                <a href="<?php echo $cat_link; ?>">
                  <div class="main_page__category_item">
                    <img data-lazy-src="<?php echo $cat_image; ?>" alt="<?php echo $cat->name; ?>" 
                      srcset="<?php echo wp_get_attachment_image_srcset( $thumbnail_id ); ?>"
                      height="178px"
                      width="335px" />
                    <div class="main_page__category_text">
                      <h4 class="main_page__category_title"><?php echo $cat->name; ?></h4>
                      <span class="account_orders_link_a">Shop now</span>
                    </div>
                  </div>
                </a>


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
                  'exclude' => '52',
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
                  <a href="<?php echo $cat_link; ?>">
                    <img data-lazy-src="<?php echo $cat_image; ?>" alt="<?php echo $cat->name; ?>" />
                  </a>
                  <div class="main_page__category_text">
                    <h4 class="main_page__category_title"><?php echo $cat->name; ?></h4>
                    <a class="account_orders_link_a" href="<?php echo $cat_link; ?>">Shop now</a>
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
          wp_reset_query();
        ?>

      <?php
        $id = get_field('product_promo');
        $product   = wc_get_product( $id);
        $post_thumbnail_id = $product->get_image_id();
        $product_type = $product->get_type();
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
            <h3 class="text_48"><?php  echo $product->get_title();  ?></h3>
            <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
          </div>
          <div class="main_page__promo_carousel carousel">

            <?php
            $attachment_ids = $product->get_gallery_attachment_ids();
            array_unshift($attachment_ids, $post_thumbnail_id);
            foreach( $attachment_ids as $attachment_id ) { ?>
              <div class="carousel__slide">
                <img data-lazy-src="<?php echo wp_get_attachment_url($attachment_id);?>" alt="<?php echo $product->get_name(); ?>" 
                srcset="<?php echo wp_get_attachment_image_srcset( $attachment_id ); ?>" />
              </div>
            <?php }
            ?>
          </div>

          <div class="summary entry-summary main_page__summary">
            <?php do_action( 'woocommerce_'.$product_type.'_add_to_cart' ); ?>
          </div>

          <div class="main_page__promo_images">
            <div class="promo_image__main_photo">
              <img loading="lazy" src="<?php echo get_the_post_thumbnail_url($product->id);?>"
                alt="<?php echo $product->get_title(); ?>"
                srcset="<?php echo wp_get_attachment_image_srcset( $product->get_image_id() ); ?>"
                height="604px"
                width="520px"/>
            </div>

            <div class="promo_image__thumbnail">
          <?php
          $attachment_ids = $product->get_gallery_attachment_ids();
          foreach( $attachment_ids as $attachment_id ) { ?>
              <img data-lazy-src="<?php echo wp_get_attachment_url($attachment_id);?>" alt="<?php echo $product->get_title(); ?>" srcset="<?php echo wp_get_attachment_image_srcset( $attachment_id ); ?>" />
          <?php }
          ?>
            </div>
          </div>
        </div>
      </section>

      <section class="main_page__showcase">
        <div class="container">
          <h2 class="text_32">Everyday clothes</h2>
          <div class="main_page__showcase_carousel everyday_clothes_mobile carousel">

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
                  <a href="<?php echo $cat_link; ?>">
                    <div class="showcase_parent_img">
                      <img loading="lazy" src="<?php echo $cat_image; ?>" alt="<?php echo get_the_category_by_ID($category_id);?>"
                      srcset="<?php echo wp_get_attachment_image_srcset( $thumbnail_id, 'medium_large' ) ?>"/>
                    </div>
                  </a>
                  <div class="main_page__showcase_text">
                    <h4 class="main_page__showcase_title"><?php echo get_the_category_by_ID($category_id);?></h4>
                    <a href="<?php echo $cat_link; ?>" class="account_orders_link_a">Go shopping</a>
                  </div>
                </div>

              <?php } ?>

              <?php
              wp_reset_postdata(); ?>
            <?php } ?>

          </div>
          <div class="main_page__showcase_carousel everyday_clothes_desktop">
          <?php
              if( $categories ) { ?>

                <?php foreach( $categories as $cat ){?>
                <?php
									$category_id = $cat;
                  $cat_link = get_category_link( $category_id );
                  $image_url = wp_get_attachment_image( $category_id );

                  $thumbnail_id = get_woocommerce_term_meta( $category_id, 'thumbnail_id', true );
                  $cat_image = wp_get_attachment_url( $thumbnail_id );
                  ?>

                <div class="main_page__showcase_item">
                  <a href="<?php echo $cat_link; ?>">
                    <div class="showcase_parent_img">
                      <img loading="lazy" src="<?php echo $cat_image; ?>" alt="<?php echo get_the_category_by_ID($category_id);?>" />
                    </div>
                  </a>
                  <div class="main_page__showcase_text">
                    <h4 class="main_page__showcase_title"><?php echo get_the_category_by_ID($category_id);?></h4>
                    <a href="<?php echo $cat_link; ?>" class="account_orders_link_a">Go shopping</a>
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

                <?php the_field('setificates_desc_1'); ?>

              <span class="link_gift_card">Choose a certificate</a>
            </div>
          </div>
          <a href="<?php the_field('setificates_link_2'); ?>" class="main_page__sertificate_item sertificates__shipping">
            <div class="sertificates_parent"></div>
            <div class="gift_sertificates__text">
              <h4><?php the_field('setificates_title_2'); ?></h4>

                <?php the_field('setificates_desc_2'); ?>

              <span><?php the_field('setificates_link_name_2'); ?></span>
            </div>
          </a>
        </div>
        <div class="gift_card_panel">
          <div class="gift_card_content">
            <div>
              <h2>Choose a voucher</h2>
              <div class="gift_card_wraper">
                <?php echo do_shortcode('[product_page id="1487"]'); ?>
                <?php echo do_shortcode('[product_page id="1488"]'); ?>
              </div>
            </div>

            <p>Gift certificates are electronic. After purchase, we will send you a promo code to the mail you specify <a href="#" class="account_orders_link_a inline">Learn more about the conditions</a></p>
            <span class="gift_cadr_cross"></span>
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
                  'post__not_in' => array( 1487, 1488 ),
                );
                $my_query = new WP_Query( $args );
                while ($my_query->have_posts()) : $my_query->the_post();
                ?>

          <?php
            global $product;
            $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
          ?>
          <?php $product__type = $product->get_type();
           if ($product__type != 'pw-gift-card') { ?>
            <div class="main_page__showcase_item carousel__slide <?php echo $count; ?>">    
             <a href="<?php echo esc_url( $link ); ?>">
                <div class="showcase_parent_img">
                  <?php
                  $id = $product->get_id();
                  $product   = wc_get_product( $id);
                  $image_id  = $product->get_image_id();
                  $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                  ?>
                  <img data-lazy-src="<?php echo $image_url; ?>"  alt="<?php the_title(); ?>" 
                    srcset="<?php echo wp_get_attachment_image_srcset( $image_id ) ?>" />
                </div>
                <div class="main_page__showcase_text">
                  <h5 class="text_18 h5_product"><?php the_title(); ?></h5>
                  <p class="price text_18">$ <?php echo $product->get_price() ?></p>
                </div>
              </a>
            </div>

          <?php } ?>
            
            <?php $count++; ?>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>

          </div>
        </div>
      </section>

      <?php $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
        if ( !empty($viewed_products) ) { ?>
          <section class="main_page__popular_products main_page__showcase">
            <div class="container">
              <h2 class="text_32">Reviewed products</h2>
              <div class="main_page__showcase_carousel carousel">
                <?php echo do_shortcode("[woocommerce_recently_viewed_products]"); ?>
              </div>
            </div>
          </section>
        <?php }
      ?>

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
              <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                <img data-lazy-src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title();?>" />
              </a>
              <div class="post_info">
                <span class="post_date"><?php the_time( 'F j, Y' ); ?></span>
                <div class="post_comment">
                  <?php
                    $comments_count = wp_count_comments($post->ID);
                    echo $comments_count->approved.' comments' ;
                  ?>
                </div>
              </div>
              <div class="main_page__blog_text">
                <h4 class="text_24"><?php the_title();?></h4>
                <p>
                  <?php  echo wp_trim_words( get_the_content(), 8, ' ...' ); ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="account_orders_link_a">Read more</a>
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
            <h2 class="text_32">Contacts</h2>
            <p>Our clothes can now be purchased in the store</p>
            <div class="main_page__contacts_links">
              <a href="<?php the_field('map_link', 'option'); ?>" class="contacts__adress a_blue_hover" target="_blank"	><?php the_field('adress', 'option'); ?></a>
              <a href="tel:<?php the_field('phone', 'option'); ?>" class="contacts__phone a_blue_hover"><?php the_field('phone', 'option'); ?></a>
              <a href="mailto:<?php the_field('mail', 'option'); ?>" class="contacts__email a_blue_hover"><?php the_field('mail', 'option'); ?></a>
            </div>
          </div>
          <div class="map">
            <?php the_field('map_frame', 'option'); ?>
          </div>
        </div>
      </section>

  </main>

<?php
get_footer();
?>