<?php
/**
 * The Template for displaying all single products
 * @version     1.6.4
 */

get_header( 'shop' ); ?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

<?php get_footer( 'shop' ); ?>
