<!DOCTYPE html>
<html <?php language_attributes(); ?> >
   <head>
      <base href="https://keepaustinsexy.com/">
      <title><?php bloginfo('name'); echo " - ";  bloginfo('description');?></title>
     <link rel="dns-prefetch" href="https://cdn.jsdelivr.net"/>
     <link rel="dns-prefetch" href="https://gstatic.com"/>
     <link rel="dns-prefetch" href="https://google.com"/>
     <link rel="dns-prefetch" href="https://developers.google.com"/>
     <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>
      <?php do_action( 'wpseo_head' );  ?>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0 ">
      <?php
      $target = get_template_directory_uri(); ?>
      <!-- <link rel="preload" href="https://keepaustinsexy.com/wp-content/uploads/2022/03/banner_1.jpg" as="image"/> -->
      <?php wp_head(); ?>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
      <link rel="stylesheet" href="<?php echo $target; ?>/css/style.css?ver=<?php echo time();?>" />
   </head>
   <body <?php body_class( $class ) ?>>
      <?php global $woocommerce; ?>
      <?php wp_body_open(); ?>
      <header>
         <div class="header__mobile">
            <div class="container header__mobile_container">
               <div class="logo">
                  <?php the_custom_logo( ); ?>
               </div>

               <div>
                <?php $locations = get_nav_menu_locations(); ?>
                <?php $menumenu = wp_get_menu_array($locations['primary_menu']); ?>
                <?php if($menumenu) { ?>
                <div class="header__nav">
                    <?php foreach ($menumenu as $menu) : ?>
                    <a href="<?php echo $menu['href']; ?>" class="nav-link"><?php echo $menu['title']; ?></a>
                    <?php endforeach; ?>
                </div>
                <?php } ?>
               </div>

               <div class="header__links_group">
                  <button class="header_link header_search"></button>
                  <div class="header_search_panel_overlay">
                     <div class="header_search_panel">
                        <div class="header_search_input">
                           <input type="search" id="input_search" placeholder="Try to search something..."/>
                           <button class="header_panel_cross"></button>
                        </div>
                        <div class="header_search_result" id="ajax_search_result">
                        </div>
                     </div>
                  </div>
                  
                  <?php 
                     $image_account;
                     if ( is_user_logged_in() ) {
                        $image_account = 'account_logged';
                     } else {
                        $image_account = 'login';
                     }
                  ?>
                  <a class="header_link header_account"
                     href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
                     style="background-image: url('<?php echo bloginfo('template_url');?>/images/header/<?php echo $image_account; ?>.svg');">
                  </a>
                  <a class="header_link header_cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" >
                     <span class="count_bag"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
                  </a>
                  <!-- <button class="header_link header_cart" href="<?php /* echo esc_url( wc_get_cart_url() ); */ ?>" >
                     <span class="count_bag"><?php /* echo $woocommerce->cart->cart_contents_count; */ ?></span>
                  </button> -->
                  <button class="header__mobile_btn"></button>
                  <div class="header__mobile_panel">
                      <div class="header_parent_search">
                        <button class="header__mobile_btn_cross"></button>
                      </div>
                      <?php $locations = get_nav_menu_locations(); ?>
                      <?php $menumenu = wp_get_menu_array($locations['primary_menu']); ?>
                      <?php if($menumenu) { ?>
                      <nav class="header_mobile_nav">
                        <?php foreach ($menumenu as $menu) : ?>
                        <a href="<?php echo $menu['href']; ?>" class="nav-link header_mobile_nav_item"><?php echo $menu['title']; ?></a>
                        <?php endforeach; ?>
                      </nav>
                      <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </header>

      <div class="mini_cart__overlay">
         <div class="mini_cart_panel" >
         <?php woocommerce_mini_cart(); ?>
         </div> 
      </div>