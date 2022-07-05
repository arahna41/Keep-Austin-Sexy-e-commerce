<? /* Template name: FAQ */ ?>

<?php get_header(); ?>

  <main class="account__main info__main">
    
    <?php get_template_part( 'faq_nav' ); ?>
    <section class="faq_info  info_panel" data-section="faq">
      <div class="tab_content">
        <h1 class="account__h3 text_24">FAQ</h1>
        <div class="faq_accordion">

          <?php
            $my_posts = get_posts( array(
              'numberposts' => -1,
              'category_name'    => 'faq',
              'orderby'     => 'date',
              'order'       => 'ASC',
              'post_type'   => 'post',
              'suppress_filters' => true,
            ) );

            foreach( $my_posts as $post ){
              setup_postdata( $post );
              ?>
                <div class="faq_item">
                  <div class="faq_header">
                    <h3><?php the_title(); ?></h3>
                  </div>
                  <div class="faq_content">
                    <p><?php the_content(); ?></p>
                  </div>
                </div>
              <?php
            }

            wp_reset_postdata(); 
          ?>
          
        </div>
      </div>
    </section>
  </main>

<?php get_footer(); ?>