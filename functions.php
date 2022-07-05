<?php
/** 
 * Enables the HTTP Strict Transport Security (HSTS) header in WordPress. 
 */
function tg_enable_strict_transport_security_header() {
    header( 'Strict-Transport-Security: max-age=31536000' );
}
function tg_enable_x_frame_options() {
	header('X-Frame-Options: SAMEORIGIN');
}
function tg_enable_x_content_type_options() {
	header('X-Content-Type-Options: nosniff');
}
add_action( 'send_headers', 'tg_enable_strict_transport_security_header' );
add_action( 'send_headers', 'tg_enable_x_frame_options' );
add_action( 'send_headers', 'tg_enable_x_content_type_options' );

update_option('siteurl','https://keepaustinsexy.com/');
update_option('home','https://keepaustinsexy.com/');

function wp_get_menu_array($current_menu) {

    $array_menus = wp_get_nav_menu_items($current_menu);
    $menu = array();

    foreach ($array_menus as $array_menu) {
        if (empty($array_menu->menu_item_parent)){
            $curent_id = $array_menu->ID;
            $menu[$curent_id] = array(
                'id'         =>   $curent_id,
                'title'      =>   $array_menu->title,
                'href'        =>  $array_menu->url,
                'children'    =>   array(),
                'class'       =>  $array_menu->classes
            );
        }

        if (isset($curent_id) && $curent_id == $array_menu->menu_item_parent) {
            $submenu_id = $array_menu->ID;
            $menu[$curent_id]['children'][$array_menu->ID] = array(
                'id'         =>   $submenu_id,
                'title'      =>   $array_menu->title,
                'href'        =>  $array_menu->url,
                'children'    =>   array(),
                'object'      =>  $array_menu->object_id,
                'parent'      =>  $array_menu->post_parent,
            );
        }

        if (isset($submenu_id) && $submenu_id == $array_menu->menu_item_parent) {
            $menu[$curent_id]['children'][$submenu_id]['children'][$array_menu->ID] = array(
                'id'         =>   $array_menu->ID,
                'title'      =>   $array_menu->title,
                'href'        =>  $array_menu->url,
                'object'      =>  $array_menu->object_id,
                'parent'      =>  $array_menu->post_parent,
            );
        }
    }

    return $menu;
}

function go_setup() {
		// This theme uses wp_nav_menu() in four location.
		register_nav_menus( array(
      'primary_menu'=> esc_html__( 'primary_menu', 'keep-austin-sexy' ),
      'footer1'     => esc_html__( 'footer1', 'keep-austin-sexy' ),
      'footer2'     => esc_html__( 'footer2', 'keep-austin-sexy' ),
      'footer3'     => esc_html__( 'footer3', 'keep-austin-sexy' ),

		) );
}
add_action( 'after_setup_theme', 'go_setup' );

//options
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

//acf
add_filter( 'acf/save_post', 'acf_clear_object_cache' );
function acf_clear_object_cache( $post_id ) {
    if ( empty( $_POST['acf'] ) ) {
        return;
    }
    // clear post related cache
    clean_post_cache( $post_id );
    // clear ACF cache
    if ( is_array( $_POST['acf'] ) ) {
        foreach ( $_POST['acf'] as $field_name => $value ) {
            $cache_slug = "load_value/post_id={$post_id}/name={$field_name}";
            wp_cache_delete( $cache_slug, 'acf' );
        }
    }
}

//SEO
//%%excerpt%%
function retrieve_var1_replacement( $var1 ) {
        global $post;
       return strip_tags($post->post_content);
}
function register_my_plugin_extra_replacements() {
       wpseo_register_var_replacement( '%%mycustomdesc%%', 'retrieve_var1_replacement', 'advanced', 'this is a help text for myvar1' );
}
add_action( 'wpseo_register_extra_replacements', 'register_my_plugin_extra_replacements' );


add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
function add_async_attribute($tag, $handle)
{
    if(!is_admin()){
        if ('jquery-core' == $handle) {
            return $tag;
        }
        return str_replace(' src', ' defer src', $tag);
    }else{
        return $tag;
    }
}

add_filter( 'excerpt_length', function($length) {
    return 10;
} );

function new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

add_theme_support( 'woocommerce' );

///woocommerce_breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {

    $bt='Home';

    return array(
        'delimiter' => '/',
        'wrap_before' => '<ol class="breadcrumb" itemprop="breadcrumb">',
        'wrap_after' => '</ol>',
        'before' => '<li class="breadcrumb-item">',
        'after' => '</li>',
        'home'        => _x( $bt, 'breadcrumb', 'woocommerce' ),
    );
}

function my_empty_cart() {
  global $woocommerce;
    if (isset( $_GET['empty-cart'] ) ) {
        wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'product' ) ) );
    }
}
add_action( 'init', 'my_empty_cart' );

/*
 * load more script call back
 */
function ajax_script_load_more($args) {
    //init ajax
    $ajax = false;
    //check ajax call or not
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $ajax = true;
    }
    //number of posts per page default
    $num =6;
    //page number
    $paged = $_POST['page'] + 1;
    //args
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' =>$num,
        'paged'=>$paged
    );
    //query
    $query = new WP_Query($args);
    //check
    if ($query->have_posts()):
        //loop articales
        while ($query->have_posts()): $query->the_post();
        $comments_count = wp_count_comments($post->ID);
        echo
        '
          <div class="blog_catalog_post">
            <div class="post_img">
              <img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" />
            </div>
            <div class="post_info">
              <span class="post_date">'.get_the_time( "F j, Y" ).'</span>
              <div class="post_comment">'.$comments_count->approved." comments".'</div>
            </div>
            <h3 class="post_title">'.get_the_title().'</h3>
            <p class="post_desc">'. wp_trim_words( get_the_content(), 54, " ..." ).'</p>
            <a href="'.get_the_permalink().'" class="read_more">Read more</a>
          </div>
        ';
        endwhile;
    else:
        echo 0;
    endif;
    //reset post data
    wp_reset_postdata();
    //check ajax call
    if($ajax) die();
}

add_action('wp_ajax_nopriv_ajax_script_load_more', 'ajax_script_load_more');
add_action('wp_ajax_ajax_script_load_more', 'ajax_script_load_more');


//cart header
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
    $fragments['span.count_bag'] = '<span class="count_bag">' . WC()->cart->get_cart_contents_count() . '</span>' ;

    return $fragments;
}

// -------------
// 1. Show plus minus buttons

add_action( 'woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus' );

function bbloomer_display_quantity_plus() {
   echo '<button type="button" class="plus">+</button>';
}

add_action( 'woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus' );

function bbloomer_display_quantity_minus() {
   echo '<button type="button" class="minus">-</button>';
}

// -------------
// 2. Trigger update quantity script

add_action( 'wp_footer', 'bbloomer_add_cart_quantity_plus_minus' );

function bbloomer_add_cart_quantity_plus_minus() {

   if (  is_product() || is_cart() || is_front_page() ) {
    wc_enqueue_js( "

        jQuery(document).on( 'click', 'button.plus, button.minus', function() {

            var qty = jQuery( this ).parent( '.quantity' ).find( '.qty' );
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));

            if ( jQuery( this ).is( '.plus' ) ) {
                if ( max && ( max <= val ) ) {
                qty.val( max ).change();
                } else {
                qty.val( val + step ).change();
                }
            } else {
                if ( min && ( min >= val ) ) {
                qty.val( min ).change();
                } else if ( val > 1 ) {
                qty.val( val - step ).change();
                }
            }
            jQuery('.update_btn').attr('aria-disabled', 'false');
            jQuery('.update_btn').removeAttr('disabled');
            jQuery('.update_btn').trigger('click');
        });
    " );
    }
    if (  is_checkout() ) {

    wc_enqueue_js( "

        jQuery(document).on( 'click', 'button.plus, button.minus', function() {

            var qty = jQuery( this ).parent( '.quantity' ).find( '.qty' );
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));

            if ( jQuery( this ).is( '.plus' ) ) {
                if ( max && ( max <= val ) ) {
                qty.val( max ).change();
                } else {
                qty.val( val + step ).change();
                }
            } else {
                if ( min && ( min >= val ) ) {
                qty.val( min ).change();
                } else if ( val > 1 ) {
                qty.val( val - step ).change();
                }
            }
        });
    " );

    ?>
    <script type="text/javascript">
        <?php  $admin_url = get_admin_url(); ?>

        jQuery("form.checkout").on("change", "input.qty", function( event ){

            $form = jQuery( 'form.checkout' );
            if ( $form[0].checkValidity() ){
                var data = {
                    action: 'update_order_review',
                    security: wc_checkout_params.update_order_review_nonce,
                    post_data: jQuery( 'form.checkout' ).serialize()
                };

                jQuery.post( '<?php echo $admin_url; ?>' + 'admin-ajax.php', data, function( response )
                {
                    jQuery( 'body' ).trigger( 'update_checkout' );
                });
            }
        });
    </script>
    <?php
    }
}

function update_order_review() {
    $values = array();
    parse_str($_POST['post_data'], $values);
    $cart = $values['cart'];
    foreach ( $cart as $cart_key => $cart_value ){
        WC()->cart->set_quantity( $cart_key, $cart_value['qty'], false );
        WC()->cart->calculate_totals();
    }
    wp_die();
}
add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');
add_action('wp_ajax_update_order_review', 'update_order_review');

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {

	// Get shortcode parameters
	extract(shortcode_atts(array(
		"per_page" => '5'
	), $atts));

	// Get WooCommerce Global
	global $woocommerce;

	// Get recently viewed product cookies data
	$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
	$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

	// If no data, quit
	if ( empty( $viewed_products ) )
		return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );

	// Create the object
	ob_start();

	// Get products per page
	if( !isset( $per_page ) ? $number = 5 : $number = $per_page )

	// Create query arguments array
    $query_args = array(
    				'posts_per_page' => $number,
    				'no_found_rows'  => 1,
    				'post_status'    => 'publish',
    				'post_type'      => 'product',
    				'post__in'       => $viewed_products,
    				'orderby'        => 'rand',
                    'exclude'        => '1487, 1488'
    				);

	// Add meta_query to query args
	$query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

	// Create a new query
	$r = new WP_Query($query_args);

	// If query return results
	if ( $r->have_posts() ) {

		$content = '<div class="carousel__track rc_wc_rvp_product_list_widget">';

		// Start the loop
		while ( $r->have_posts()) {
			$r->the_post();
			global $product;

			$content .=
          '
            <div class="main_page__showcase_item carousel__slide ">
             <a href="' . get_permalink($r->post->ID) . '">
                <div class="showcase_parent_img">
                  <img src="'.get_the_post_thumbnail_url($r->post->ID).'"  alt="' . get_the_title($r->post->ID) . '" />
                </div>
                <div class="main_page__showcase_text">
                  <h5 class="text_18 h5_product">' . get_the_title($r->post->ID) . '</h5>
                  <p class="price text_18">$ '. $product->get_price() .'</p>
                </div>
              </a>
            </div>
            ';

		}
		$content .= '</div>';
	}

	// Get clean object
	$content .= ob_get_clean();

	// Return whole content
	return $content;
}

// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "rc_woocommerce_recently_viewed_products");

function set_user_visited_product_cookie() {
    global $post;

    $Existing_product_id = $_COOKIE['woocommerce_recently_viewed'];
    if ( is_product() )
    {
        $updated_product_id = $Existing_product_id.'|'.$post->ID;
        wc_setcookie( 'woocommerce_recently_viewed',  $updated_product_id );
    }
}

add_action( 'wp', 'set_user_visited_product_cookie' );

function wc_track_product_view_always() {
    if ( ! is_singular( 'product' ) /* xnagyg: remove this condition to run: || ! is_active_widget( false, false, 'woocommerce_recently_viewed_products', true )*/ ) {
        return;
    }

    global $post;

    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
    }

    // Unset if already in viewed products list.
    $keys = array_flip( $viewed_products );

    if ( isset( $keys[ $post->ID ] ) ) {
        unset( $viewed_products[ $keys[ $post->ID ] ] );
    }

    $viewed_products[] = $post->ID;

    if ( count( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }

    // Store for session only.
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}

remove_action('template_redirect', 'wc_track_product_view', 20);

// add the ajax_search
add_action( 'wp_footer', 'ajax_search' );
function ajax_search() {
?>
<script type="text/javascript">
    
var timeout;
jQuery(document).ready(function($) {
    jQuery('#input_search').keydown(function (e) {
        var keywordval = jQuery(this).val();
        var n = keywordval.length;

        clearTimeout(timeout);
        timeout = setTimeout(function() {

            if ( n >= 2 ){
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'ajax_search_data',
                        keyword: keywordval
                    },
                    success: function(data) {
                        jQuery('#ajax_search_result').html( data );
                    }
                });
            } else {
                data = '';
                jQuery('#ajax_search_result').html( data );
            }
        }, 300);
    });
})
</script>
<?php
}

// the ajax_search_data
add_action('wp_ajax_ajax_search_data' , 'ajax_search_data');
add_action('wp_ajax_nopriv_ajax_search_data','ajax_search_data');
function ajax_search_data(){
    $keyword = $_POST['keyword'];
    $search_args=array(
        'posts_per_page' => -1,
        's' => esc_attr( $keyword ),
    );
    $the_query = new WP_Query($search_args);
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post();

        $myquery = esc_attr( $keyword );
        $a = $myquery;
        $search = get_the_title();
        if( stripos("/{$search}/", $a) !== false) {
            if( 'product' === get_post_type() || 'post' === get_post_type()) {
                echo'
                <a href="'.get_the_permalink().'" class="link_wraper header_search_result_item">
                    <div class="search_img_parent">
                    <img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" />
                    </div>
                    <div class="search_result__content">
                        <h5 class="text_18 h5_product">'.get_the_title().'</h5>
                        <p class="type_of_post">' . get_post_type() . '</p>
                    </div>
                </a>
                ';
            }
        }
        endwhile;
    else :
    echo'
    <div class="nothing_found">
        Nothing found :(
    </div>
    ';
    endif;
    wp_reset_postdata();
    die();
}

//checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
function custom_remove_woo_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    unset($fields['shipping']['shipping_company']);

    return $fields;
}
// Change placeholder and label text
add_filter( 'woocommerce_checkout_fields' , 'custom_rename_wc_checkout_fields' );
function custom_rename_wc_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name']['placeholder'] = 'First name';
	$fields['billing']['billing_last_name']['placeholder'] = 'Last name';
	$fields['billing']['billing_city']['placeholder'] = 'Town / City';
	$fields['billing']['billing_postcode']['placeholder'] = 'ZIP Code';
	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
    $fields['billing']['billing_email']['placeholder'] = 'e-mail';

    $fields['shipping']['shipping_first_name']['placeholder'] = 'First name';
    $fields['shipping']['shipping_last_name']['placeholder'] = 'Last name';
    $fields['shipping']['shipping_postcode']['placeholder'] = 'ZIP Code';
    $fields['shipping']['shipping_phone']['placeholder'] = 'Phone';
    $fields['shipping']['shipping_city']['placeholder'] = 'Town / City';

	return $fields;
}
function namespace_disable_image_sizes($sizes){
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    unset($sizes['blog-isotope']);
    unset($sizes['product_small_thumbnail']);
    unset($sizes['shop_catalog']);
    unset($sizes['shop_single']);
    unset($sizes['shop_single_small_thumbnail']);
    unset($sizes['shop_thumbnail']);
    unset($sizes['woocommerce_thumbnail']);
    unset($sizes['woocommerce_single']);
    unset($sizes['woocommerce_gallery_thumbnail']);

    return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'namespace_disable_image_sizes');

// disable scaled image size
add_filter('big_image_size_threshold', '__return_false');

// disable rotated image size
add_filter('wp_image_maybe_exif_rotate', '__return_false');

// disable other image sizes
function namespace_disable_other_image_sizes(){
    remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size()
    remove_image_size('another-size');   // disable any other added image sizes
}
add_action('init', 'namespace_disable_other_image_sizes');

/* remove display name field */
add_filter('woocommerce_save_account_details_required_fields', 'remove_required_fields');

function remove_required_fields( $required_fields ) {
    unset($required_fields['account_display_name']);

    return $required_fields;
}

/* add email verify */
function wc_registration_redirect( $redirect_to ) {     // prevents the user from logging in automatically after registering their account
    wp_logout();
    wp_redirect( '/verify/?n=');                        // redirects to a confirmation message
    exit;
}

function wp_authenticate_user( $userdata ) {            // when the user logs in, checks whether their email is verified
    $has_activation_status = get_user_meta($userdata->ID, 'is_activated', false);
    if ($has_activation_status) {                           // checks if this is an older account without activation status; skips the rest of the function if it is
        $isActivated = get_user_meta($userdata->ID, 'is_activated', true);
        if ( !$isActivated ) {
            my_user_register( $userdata->ID );              // resends the activation mail if the account is not activated
            $userdata = new WP_Error(
                'my_theme_confirmation_error',
                __( '<strong>Error:</strong> Your account has to be activated before you can login. Please click the link in the activation email that has been sent to you.<br /> If you do not receive the activation email within a few minutes, check your spam folder or <a href="/verify/?u='.$userdata->ID.'">click here to resend it</a>.' )
            );
        }
    }
    return $userdata;
}

function my_user_register($user_id) {               // when a user registers, sends them an email to verify their account
    $user_info = get_userdata($user_id);                                            // gets user data
    $code = md5(time());                                                            // creates md5 code to verify later
    $string = array('id'=>$user_id, 'code'=>$code);                                 // makes it into a code to send it to user via email
    update_user_meta($user_id, 'is_activated', 0);                                  // creates activation code and activation status in the database
    update_user_meta($user_id, 'activationcode', $code);
    $url = get_site_url(). '/verify/?p=' .base64_encode( serialize($string));       // creates the activation url
    $html = ( 'Please click <a href="'.$url.'">here</a> to verify your email address and complete the registration process.' ); // This is the html template for your email message body
    wc_mail($user_info->user_email, __( 'Activate your Account' ), $html);          // sends the email to the user
}

function my_init(){                                 // handles all this verification stuff
    if(isset($_GET['p'])){                                                  // If accessed via an authentification link
        $data = unserialize(base64_decode($_GET['p']));
        $code = get_user_meta($data['id'], 'activationcode', true);
        $isActivated = get_user_meta($data['id'], 'is_activated', true);    // checks if the account has already been activated. We're doing this to prevent someone from logging in with an outdated confirmation link
        if( $isActivated ) {                                                // generates an error message if the account was already active
            wc_add_notice( __( 'This account has already been activated. Please log in with your username and password.' ), 'error' );
        }
        else {
            if($code == $data['code']){                                     // checks whether the decoded code given is the same as the one in the data base
                update_user_meta($data['id'], 'is_activated', 1);           // updates the database upon successful activation
                $user_id = $data['id'];                                     // logs the user in
                $user = get_user_by( 'id', $user_id ); 
                if( $user ) {
                    wp_set_current_user( $user_id, $user->user_login );
                    wp_set_auth_cookie( $user_id );
                    do_action( 'wp_login', $user->user_login, $user );
                }
                wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! You have been logged in and can now use the site to its full extent.' ), 'notice' );
            } else {
                wc_add_notice( __( '<strong>Error:</strong> Account activation failed. Please try again in a few minutes or <a href="/verify/?u='.$userdata->ID.'">resend the activation email</a>.<br />Please note that any activation links previously sent lose their validity as soon as a new activation email gets sent.<br />If the verification fails repeatedly, please contact our administrator.' ), 'error' );
            }
        }
    }
    if(isset($_GET['u'])){                                          // If resending confirmation mail
        my_user_register($_GET['u']);
        wc_add_notice( __( 'Your activation email has been resent. Please check your email and your spam folder.' ), 'notice' );
    }
    if(isset($_GET['n'])){                                          // If account has been freshly created
        wc_add_notice( __( 'Thank you for creating your account. You will need to confirm your email address in order to activate your account. An email containing the activation link has been sent to your email address. If the email does not arrive within a few minutes, check your spam folder.' ), 'notice' );
    }
}

// the hooks to make it all work
add_action( 'init', 'my_init' );
add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
add_filter('wp_authenticate_user', 'wp_authenticate_user',10,2);
add_action('user_register', 'my_user_register',10,2);

/* redirect after log in to main page */
add_filter( 'woocommerce_login_redirect', 'custom_login_redirect', 25, 2 );
 
function custom_login_redirect( $redirect, $user ) {
	$redirect = site_url();
	return $redirect;
}

add_theme_support( 'custom-logo' );

/* clear cart */
add_action('init', 'woocommerce_clear_cart_url');
function woocommerce_clear_cart_url() {
    global $woocommerce;
    if( isset($_REQUEST['clear-cart']) ) {
        $woocommerce->cart->empty_cart();
    }
}