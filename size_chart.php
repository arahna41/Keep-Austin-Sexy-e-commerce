<?php
// Template Name: Size chart
get_header(); 
?>

<main class="account__main info__main">
  <?php get_template_part( 'faq_nav' ); ?>

  <div class="info_pages_content">
    <h1 class="account__h3 text_24"><?php the_title(); ?></h1>
  
      <?php the_content(); ?>
      
  </div>
</main>

<?php get_footer(); ?>