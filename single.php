

<?php get_header(); ?>
<?php   $target = get_template_directory_uri(); ?>

    <section class="post_page">
      <div class="container">
        <ul class="breadcrumbs">
          <li>
            <a href="<?php echo esc_url(home_url('/'));?>">Home</a>
          </li>
          <li>
            <a href="<?php echo get_permalink(730);?>"><?php echo get_the_title(730); ?></a>
          </li>
          <li>
            <span><?php the_title(); ?></span>
          </li>
        </ul>

        <div class="posts_wrapper">
          <div class="post_page_info">

            <div class="post_content">
              <div class="post_image">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />

                <div class="post_info post_info_page">
                  <span class="post_date"><?php the_time( 'F j, Y' ); ?></span>
                  <div class="post_comment">
                    <?php
                      $comments_count = wp_count_comments($post->ID);
                      echo $comments_count->approved.' comments' ;
                    ?>
                  </div>
                </div>
                <h2 class="post_title"><?php the_title(); ?></h2>
                <div class="post_article">
                  <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                  <?php endwhile; ?>
                  <?php endif;?>
                </div>
              </div>

              <div class="share_links">
                <span>Share this post:</span>
                <div class="socials">
					<?php
						$postUrl = 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" ; ?>
					<a target="_blank" rel="noreferrer noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $postUrl; ?>" class="link_facebook"></a>
					<a target="_blank" rel="noreferrer noopener" href="https://www.instagram.com/sharer/sharer.php?u=<?php echo $postUrl; ?>" class="link_instagram"></a>
                </div>
              </div>
            </div>

            <div class="posts_related">
              <h2>Related posts</h2>
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
                        $categories = get_the_category($post->ID);
                        $category_ids = array();
                        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                        $args = array(
                           'post_type' => array('post'),
                           'category__in' => $category_ids,
                           'post__not_in' => array($post->ID),
                           'showposts'=>5,
                           'orderby' => 'rand',
                           'order' => 'DESC',
                           'caller_get_posts'=>1,
                           'posts_per_page' => 16,
                           'post_status' => 'publish',
                        );
                        $my_query = new WP_Query( $args );
                        while ($my_query->have_posts()) : $my_query->the_post();
                        ?>

                        <div class="main_page__blog_item carousel__slide">
                          <a href="<?php the_permalink(); ?>" class="related_post_link_img">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
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
                            <h4 class="text_24"><?php the_title(); ?></h4>
                            <p>
                              <?php  echo wp_trim_words( get_the_content(), 54, ' ...' ); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="link">Read more</a>
                          </div>
                        </div>

                        <?php
                          endwhile;
                            wp_reset_query();
                        ?>
              </div>
            </div>

            <?php comments_template( ); ?>
            
          </div>

          <div class="posts_popular">
            <h2>Popular posts</h2>

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
              "post_type" => "post",
              "post_status" => "publish",
              "posts_per_page" => 5,
              "orderby" => "meta_value_num",
              "order" => "DESC"
            );
            $my_query = new WP_Query( $args );
            while ($my_query->have_posts()) : $my_query->the_post();
            ?>

            <a href="<?php the_permalink(); ?>" class="post_popular">
              <div class="post_preview">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title();?>" />
              </div>
              <div class="post_caption">
                <span class="post_date"><?php the_time( 'F j, Y' ); ?></span>
                <h4><?php the_title();?></h4>
              </div>
            </a>

            <?php
              endwhile;
                wp_reset_query();
            ?>
          </div>
        </div>
      </div>
    </section>


<?php get_footer(); ?>