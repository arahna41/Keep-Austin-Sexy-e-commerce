<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Keep_Austin_Sexy
 */

get_header();
?>

  <main id="primary" class="site-main">
    <section class="error-404 not-found">
      <div class="content_404">
        <div class="container">
          <h1 class="title_404 text_40"><?php esc_html_e( 'Page not found', 'keep-austin-sexy' ); ?></h1>
          <p class="p_medium"><?php esc_html_e( 'The requested URL was not found on this server', 'keep-austin-sexy' ); ?></p>
          <span class="num_404 ">404</span>
          <a class="btn_style" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to homepage</a>
          
      </div><!-- .page-content -->
    </section><!-- .error-404 -->
  </main><!-- #main -->

<?php
get_footer();
