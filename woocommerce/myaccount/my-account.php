<?php
/**
 * My Account page
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;
?>
<main class="account__main">
  <section class="account__menu_section">
    <div class="account__head">
      <h1 class="account__title text_32"><?php the_title(); ?></h1>
    </div>
    <div class="account__menu_block">
      <?php do_action( 'woocommerce_account_navigation' ); ?>
    </div>
  </section>

  <section class="account__panel account__my_info" id="account__my_info">
    
    <?php	do_action( 'woocommerce_account_content' );	?>
  </section>
</main>