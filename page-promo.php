<?php
// Template Name: Promo
get_header();
?>

<main class="main landing_page">
    <section class="banner_wraper">
      <div class="banner_img" style="background-image:url('<?php the_field('banner_img', 43); ?>');">
      </div>
      <div class="banner_text_block">
        <?php $landing_page__banner = get_field('banner_text'); ?>
          <h1 class="landing_banner_title text_24"><?php echo $landing_page__banner['banner_title'] ?><span class="banner_title_second_part text_20"><?php echo $landing_page__banner['banner_title_second_part'] ?></span></h1>
          <p class="banner_text text_16"><?php echo $landing_page__banner['banner_description'] ?></p>
          <div class="banner_contact_form">
            <?php echo do_shortcode('[mailpoet_form id="3"]') ?>
          </div>
      </div>
    </section>
    <section class="philosophy" id="philosophy">
        <h2 class="philosophy_title"><?php the_field('philosophy_title'); ?></h2>
        <div class="philosophy_content">
            <div class="parent_img philosophy_content_img">
                <img src="<?php the_field('philosophy_content_img'); ?>" width="375" height="197" alt="<?php the_field('philosophy_title'); ?>">
            </div>
            <div class="philosophy_post philosophy_post_odd">
              <?php $landing_page__philosophy_post_1 = get_field('our_philosophy_post_1'); ?>
                <div class="philosophy_post_text philosophy_post_text_odd">
                    <h3><?php echo $landing_page__philosophy_post_1['philosophy_title'] ?></h3>
                    <p class="text_16"><?php echo $landing_page__philosophy_post_1['philosophy_description'] ?></p>
                </div>
                <div class="philosophy_img philosophy_img_odd">
                    <img src="<?php echo $landing_page__philosophy_post_1['philosophy_post_image'] ?>" width="335" height="246" alt="<?php echo $landing_page__philosophy_post_1['philosophy_title'] ?>">
                </div>
            </div>
            <div class="philosophy_post philosophy_post_even">
              <?php $landing_page__philosophy_post_2 = get_field('our_philosophy_post_2'); ?>
                <div class="philosophy_post_text philosophy_post_text_even">
                    <h3><?php echo $landing_page__philosophy_post_2['philosophy_title'] ?></h3>
                    <p class="text_16"><?php echo $landing_page__philosophy_post_2['philosophy_description'] ?></p>
                </div>
                <div class="philosophy_img philosophy_img_even">
                    <img src="<?php echo $landing_page__philosophy_post_2['philosophy_post_image'] ?>" width="335" height="246" alt="<?php echo $landing_page__philosophy_post_2['philosophy_title'] ?>">
                </div>
            </div>
        </div>
    </section>
    <section class="contact_form_middle_wraper contact_form_wraper">
        <div class="contact_form_middle_img" style="background-image:url('<?php the_field('contact_form_middle_image'); ?>');"></div>
        <div class="empty"></div>
        <div class="absolute">
            <div class="contact_form_middle_wraper_text contact_form_wraper_text">
              <?php $landing_page__contact_form_middle = get_field('contact_form_middle_text'); ?>
                <h2 class="contact_form_middle_wraper_text_title contact_form_wraper_text_title"><?php echo $landing_page__contact_form_middle['contact_form_title'] ?></h2>
                <p class="contact_form_middle_wraper_text_desc text_16"><?php echo $landing_page__contact_form_middle['contact_form_desc'] ?></p>
                <div class="contact_form contact_form_middle_form">
                    <?php echo do_shortcode('[mailpoet_form id="3"]') ?>
                </div>
            </div>
        </div>
    </section>
    <section class="about_us" id="about_us">
        <h2 class="about_us_title"><?php the_field('about_us_title'); ?></h2>
        <div class="about_us_post_wraper">
            <div class="about_us_post about_us_post_odd">
              <?php $landing_page__about_us_1 = get_field('about_us_post_1'); ?>
                <div class="about_us_text_block">
                    <h3 class="about_us_text_title"><?php echo $landing_page__about_us_1['title'] ?></h3>
                    <p class="about_us_desc text_16"><?php echo $landing_page__about_us_1['description'] ?></p>           
                </div>
                <div class="about_us_post_img parent_img">
                    <img src="<?php echo $landing_page__about_us_1['post_image'] ?>" width="335" height="246" alt="<?php echo $landing_page__about_us_1['title'] ?>">                        
                </div>
            </div>
            <div class="about_us_post about_us_post_even">
              <?php $landing_page__about_us_2 = get_field('about_us_post_2'); ?>
                <div class="about_us_text_block about_us_text_block_even">
                    <h3 class="about_us_text_title"><?php echo $landing_page__about_us_2['title'] ?></h3>
                    <p class="about_us_desc text_16"><?php echo $landing_page__about_us_2['description'] ?></p>           
                </div>
                <div class="about_us_post_img about_us_post_img_even parent_img">
                    <img src="<?php echo $landing_page__about_us_2['post_image'] ?>" width="335" height="246" alt="<?php echo $landing_page__about_us_2['title'] ?>">                        
                </div>
            </div>
        </div>
    </section>
    <section class="showcase" id="showcase">
        <h2 class="showcase_title"><?php the_field('showcase_title'); ?></h2>
        <div class="showcase_post">
            <div class="showcase_post_text">
                <h3 class="showcase_post_text_title"><?php the_field('showcase_post_title'); ?></h3>
                <p class="showcase_post_text_descr text_16"><?php the_field('showcase_post_descr'); ?></p>
            </div>
        </div>
        <div class="showcase_carousel carousel">
          <?php $landing_page__showcase_images = get_field('showcase_images'); ?>
          <div class="slide_1 carousel__slide">
              <img src="<?php echo $landing_page__showcase_images['showcase_image_1'] ?>" width="335" height="658" alt="popular_gallery_1"/>
          </div>
          <div class="slide_2 carousel__slide">
              <img src="<?php echo $landing_page__showcase_images['showcase_image_2'] ?>" width="335" height="658" alt="popular_gallery_2"/>
          </div>
          <div class="slide_3 carousel__slide">
              <img src="<?php echo $landing_page__showcase_images['showcase_image_3'] ?>" width="335" height="658" alt="popular_gallery_3"/>
          </div>
          <div class="slide_4 carousel__slide">
              <img src="<?php echo $landing_page__showcase_images['showcase_image_4'] ?>" width="335" height="658" alt="popular_gallery_4"/>
          </div>
        </div>
        <div class="showcase_post_2">
            <div class="left_block_showcase">
                <div class="showcase_post_desktop">
                    <h3 class="showcase_post_text_title"><?php the_field('showcase_post_title'); ?></h3>
                    <p class="showcase_post_text_descr text_16"><?php the_field('showcase_post_descr'); ?> </p>
                </div>
                <div class="slide_1">
                    <img src="<?php echo $landing_page__showcase_images['showcase_image_1'] ?>" alt="popular_gallery_1"/>
                </div>
                <div class="slide_2">
                    <img src="<?php echo $landing_page__showcase_images['showcase_image_2'] ?>" alt="popular_gallery_2"/>
                </div>
            </div>
            <div class="right_block_showcase">
                <div class="slide_3">
                    <img src="<?php echo $landing_page__showcase_images['showcase_image_3'] ?>" alt="popular_gallery_3"/>
                </div>
                <div class="slide_4">
                    <img src="<?php echo $landing_page__showcase_images['showcase_image_4'] ?>" alt="popular_gallery_4"/>
                </div>
            </div>
        </div>
    </section>
    <section class="contact_form_bottom_wraper contact_form_wraper">
        <div class="contact_form_bottom_img" style="background-image:url('<?php the_field('contact_form_bottom_image'); ?>');"></div>
        <div class=""></div>
        <div class="absolute">
            <div class="contact_form_bottom_wraper_text contact_form_wraper_text">
              <?php $landing_page__contact_form_bottom = get_field('contact_form_bottom_text'); ?>
                <h2 class="contact_form_bottom_wraper_text_title contact_form_wraper_text_title"><?php echo $landing_page__contact_form_bottom['contact_form_title'] ?></h2>
                <p class="contact_form_bottom_wraper_text_desc text_16"><?php echo $landing_page__contact_form_bottom['contact_form_desc'] ?></p>
                <div class="contact_form" action="#">
                  <?php echo do_shortcode('[mailpoet_form id="3"]') ?>
                </div>
            </div>
        </div>
    </section>
    <div class="fixed fixed_none">
      <div class="window" style="background-image:url('<?php the_field('pop_up_image'); ?>)";>
        <div class="window_image"></div>
        <div class="window_text">
          <?php $landing_page__popup = get_field('popup_text'); ?>
          <p class="first_line_window"><?php echo $landing_page__contact_form_bottom['pop_up_title'] ?></p>
          <p class="text_16"><?php echo $landing_page__contact_form_bottom['pop_up_description'] ?></p>
        </div>
        <button class="close"></button>
      </div>
    </div>
</main>

<?php
get_footer();
?>