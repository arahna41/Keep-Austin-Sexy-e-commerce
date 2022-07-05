<?php
// Template Name: FAQ navigation
?>

<section class="info_section account__menu_section">
  <div class="info_tabs">
    <div class="section-title">
      <h1>Info</h1>
    </div>
    <div class="tabs_list account__menu_block">
      <?php if (is_page('faq') ) {
        $class1 = 'active';
      } else if (is_page('delivery-and-payment')) {
        $class2 = 'active';
      } else if (is_page('exchange-and-return')) {
        $class3 = 'active'; 
      } else if (is_page('size-chart')) {
        $class4 = 'active';
      } else if (is_page('privacy-policy')) {
        $class5 = 'active';
      } else {
        $class = '';
      } ?>
      <a href="<?php echo home_url('/faq'); ?>" class="tab_item account__menu_block_item <?php echo $class; ?> <?php echo $class1; ?>" data-menu="faq">
        FAQ
      </a>
      <a href="<?php echo home_url('/delivery-and-payment'); ?>" class="tab_item account__menu_block_item <?php echo $class; ?> <?php echo $class2; ?>" data-menu="payment">
      Delivery and payment
      </a>
      <a href="<?php echo home_url('/exchange-and-return'); ?>" class="tab_item account__menu_block_item <?php echo $class; ?> <?php echo $class3; ?>" data-menu="exchange">
        Exchange and return
      </a>
      <a href="<?php echo home_url('/size-chart'); ?>" class="tab_item account__menu_block_item <?php echo $class; ?> <?php echo $class4; ?>" data-menu="size">
        Size chart
      </a>
      <a href="<?php echo get_privacy_policy_url(); ?>" class="tab_item account__menu_block_item <?php echo $class; ?> <?php echo $class5; ?>" data-menu="privacy">
        Privacy policy
      </a>
    </div>
  </div>
</section>