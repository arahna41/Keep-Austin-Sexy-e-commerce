<footer class="site-footer">
   <div class="container">
      <div class="footer_block footer_block_1">
         <div class="logo">
            <?php the_custom_logo( ); ?>
         </div>
         <div class="contacts_links">
            <a href="<?php the_field('map_link', 'option'); ?>" class="adress a_blue_hover" target="_blank"	><?php the_field('adress', 'option'); ?></a>
            <a href="tel:<?php the_field('phone', 'option'); ?>" class="phone a_blue_hover"><?php the_field('phone', 'option'); ?></a>
            <a href="mailto:<?php the_field('mail', 'option'); ?>" class="email a_blue_hover"><?php the_field('mail', 'option'); ?></a>
         </div>
         <div class="footer__socialmedia">
            <a class="twitter" href="<?php the_field('tg', 'option'); ?>"></a>
            <a class="facebook" href="<?php the_field('fb', 'option'); ?>"></a>
            <a class="instagram" href="<?php the_field('in', 'option'); ?>"></a>
         </div>
      </div>
      <div class="footer_block footer_block_2">
         <div>
            <h5 class="btn_dropdown text_20"><?php the_field('footer_title_menu_1', 'option'); ?></h5>
            <? $locations = get_nav_menu_locations(); ?>
            <? $menus = wp_get_menu_array($locations['footer1']); ?>
            <?php if($menus) { ?>
            <div class="panel_dropdown">
               <span class="line"></span>
               <?php foreach ($menus as $menu) : ?>
               <a class="a_blue_hover" href="<?php echo $menu['href']; ?>">
               <?php echo $menu['title']; ?>
               </a>
               <?php endforeach; ?>
            </div>
            <?php } ?>
         </div>
         <div>
            <h5 class="btn_dropdown text_20"><?php the_field('footer_title_menu_2', 'option'); ?></h5>
            <? $locations = get_nav_menu_locations(); ?>
            <? $menus = wp_get_menu_array($locations['footer2']); ?>
            <?php if($menus) { ?>
            <div class="panel_dropdown">
               <span class="line"></span>
               <?php foreach ($menus as $menu) : ?>
               <a class="a_blue_hover" href="<?php echo $menu['href']; ?>">
               <?php echo $menu['title']; ?>
               </a>
               <?php endforeach; ?>
            </div>
            <?php } ?>
         </div>
         <div>
            <h5 class="btn_dropdown text_20"><?php the_field('footer_title_menu_3', 'option'); ?></h5>
            <? $locations = get_nav_menu_locations(); ?>
            <? $menus = wp_get_menu_array($locations['footer3']); ?>
            <?php if($menus) { ?>
            <div class="panel_dropdown">
               <span class="line"></span>
               <?php foreach ($menus as $menu) : ?>
               <a class="a_blue_hover" href="<?php echo $menu['href']; ?>">
               <?php echo $menu['title']; ?>
               </a>
               <?php endforeach; ?>
            </div>
            <?php } ?>
         </div>
      </div>
      <div class="footer_block footer_block_3">
         <h4 class="text_20">Good news in your inbox</h4>
         <p>
            News and updates from KAS. <br />
            No spam, we promise
         </p>
         <div class="main_page_contact_form">
            <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
         </div>
      </div>
   </div>
   <span class="line container"></span>
   <p class="copywrite"><?php the_field('copyright', 'option'); ?></p>
</footer>
<?php wp_footer();?>
<?php   $target = get_template_directory_uri(); ?>

<script defer src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.26/dist/carousel.autoplay.umd.js"></script>
<script defer src="<?php echo $target; ?>/js/script.js"></script>
</body>
</html>