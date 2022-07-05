<? /* Template name: blog */ ?>
<?php get_header(); ?>
<?php   $target = get_template_directory_uri(); ?>

    <section class="blog_catalog__banner">
      <div class="banner_title">
        <h1 class="banner_caption">Blog</h1>
      </div>
      <div class="banner_img">
        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
      </div>
    </section>

    <section class="blog_catalog">
      <ul class="breadcrumbs">
        <li>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        </li>
        <li>
          <span><?php the_title(); ?></span>
        </li>
      </ul>
      <div class="container">
        <div class="blog_catalog_posts" id="ajax-content" >

          <?php
              $index = 1;
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
                  'paged' => $my_page,
                  'posts_per_page' => 6,
                  'post_type'   => 'post',
                  'post_status' => 'publish',
              );
              $my_query = new WP_Query( $args );
          while ($my_query->have_posts()) : $my_query->the_post();
          ?>

          <div class="blog_catalog_post">
            <a href="<?php the_permalink(); ?>">
              <div class="post_img">
                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_post_thumbnail_url(); ?>" />
              </div>
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
            <h3 class="post_title"><?php the_title(); ?></h3>
            <p class="post_desc">
              <?php  echo wp_trim_words( get_the_content(), 54, ' ...' ); ?>
            </p>
            <a href="<?php the_permalink(); ?>" class="account_orders_link_a">Read more</a>
          </div>

          <?php
              $index++;
          endwhile;
          ?>
        </div>

          <?php
            $post_args=array(
            'post_type'=>'post'
            );
            $postTypes = new WP_Query($post_args);
            $numberOfPosts = $postTypes->found_posts;
          ?>

          <button class="btn_secondary main_page_blog_btn" id="loadMore"  data-page="1"  >
            See more articles
          </button>

          <script type="text/javascript">
              jQuery(document).ready(function($) {
                  //onclick
                  $("#loadMore").on('click', function(e) {
                      //init
                      var that = $(this);
                      var page = $(this).data('page');
                      var newPage = page + 1;
                      var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                      //ajax call
                      $.ajax({
                          url: ajaxurl,
                          type: 'post',
                          data: {
                              page: page,
                              action: 'ajax_script_load_more'

                          },
                          error: function(response) {
                              console.log(response);
                          },
                          success: function(response) {
                              //check
                              if (response == 0) {
                                  $('#ajax-content').append('<div class="text-center"><h3>You reached the end of the line!</h3><p>No more posts to load.</p></div>');
                                  $('#loadMore').hide();
                              } else {
                                  that.data('page', newPage);
                                  $('#ajax-content').append(response);
                              }
                          }
                      });
                  });
              })
          </script>

      </div>
    </section>


<?php get_footer(); ?>