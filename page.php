<?php get_header(); ?>
<?php   $target = get_template_directory_uri(); ?>

<?php if ( is_page(546) || is_page(545) || is_page(547) ){ ?>

      <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; ?>
      <?php endif;?>

   <?php } else { ?>

      <!-- content -->
      <div class="content">

         <!-- breadcrumb -->
        <?php
            get_template_part('/component/breadcrumb' );
            ?>
         <!-- /breadcrumb -->

         <div class="blog_post">
            <div class="row">
               <div class="col-12 block_head">
                  <?php if (!is_account_page()) { ?>
                     <h1>
                        <?php the_title(); ?>
                     </h1>
                  <?php } ?>
                  <div class="post_content">
                        <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                        <?php endwhile; ?>
                        <?php endif;?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /content -->

   <?php  } ?>

<?php get_footer(); ?>