<?php
/*  ----------------------------------------------------------------------------
    Twentynineteen Child theme
*/



add_action( 'wp_enqueue_scripts', 'enqueue_twentynineteen_child' );
function enqueue_twentynineteen_child() {

    // Enqueue the parent theme css with the parent theme version number
    wp_enqueue_style('twentynineteen-style', get_template_directory_uri() . '/style.css', '', wp_get_theme('twentynineteen')->get('Version'), 'all' );

    // Enqueue the child theme css with the child theme version number
    wp_enqueue_style('twentynineteen-child-css', get_stylesheet_directory_uri() . '/style.css', array('twentynineteen-style'), wp_get_theme('idg-academy-theme')->get('Version') );

    // Enquene child theme JS file
    wp_enqueue_script('twentynineteen-child-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), wp_get_theme('idg-academy-theme')->get('Version'), true );
}


// create a custom sidebar to be added to header
add_action( 'widgets_init', function () {
    register_sidebar(
        array (
            'name' => 'idg-top',
            'id' => 'idg-top',
            'description' => 'custom sidebar in the header',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        )
    );
});


/**
 * Add custom post types to the default tag query
 * 
 * This will make sure that the custom post types shows up in the tag archive pages.
 * The idea here is to list both normal posts and cpt named doc under the same tag name.
 *
 */
function add_cpt_to_defalt_tax_archive( $query ) {
  if ( is_tag() && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
    $query->set( 'post_type', array(
       'post', 'kurs'
    ));
  }
  return $query;
}
//add_filter( 'pre_get_posts', 'add_cpt_to_defalt_tax_archive' );

/**
 * Wordpress default optimizations 
 **/
function disable_wp_emojicons_and_more() {
	
    // Disable wp emojicons
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);

    // Remove wordpress version
    remove_action('wp_head', 'wp_generator');
    // Remove really simple discover link
    remove_action('wp_head', 'rsd_link');

}
add_action( 'init', 'disable_wp_emojicons_and_more' );

// Remove dashicons from front end
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_user_logged_in() ) {
          wp_dequeue_style('dashicons');
    }
});





/**
 * This function will connect wp_mail to your authenticated
 * SMTP server. This improves reliability of wp_mail, and
 * avoids many potential problems.
 *
 * For instructions on the use of this script, see:
 * https://www.butlerblog.com/2013/12/12/easy-smtp-email-wordpress-wp_mail/
 *
 * Values are constants set in wp-config.php
 */
add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host       = SMTP_HOST;
	$phpmailer->SMTPAuth   = SMTP_AUTH;
	$phpmailer->Port       = SMTP_PORT;
	$phpmailer->Username   = SMTP_USER;
	$phpmailer->Password   = SMTP_PASS;
	$phpmailer->SMTPSecure = SMTP_SECURE;
	$phpmailer->From       = SMTP_FROM;
	$phpmailer->FromName   = SMTP_NAME;
}


// Add support for uploading svg files
function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);


// add to your theme's functions.php file
add_filter('upload_mimes', 'add_custom_upload_mimes');
function add_custom_upload_mimes($existing_mimes) {
  	$existing_mimes['woff'] = 'application/x-font-woff';
	$existing_mimes['woff2'] = 'application/x-font-woff2';
  	return $existing_mimes;
}



/** 
 * IDG Tracking
 * Adds pixel to post and pages footer. Contact Henric Jogin for more info.
 **/
add_action( 'wp_footer', function () { if(function_exists ( 'get_the_ID' )) {
    echo '<img src="//ax.idg.se/ig01/' . get_the_ID() . '/pis.gif" width="1" height="1" style="display:none;" />';
}});

/**
 * Ahrefs-site-verification
*/
add_action( 'wp_head', function() {
    echo '<meta name="ahrefs-site-verification" content="bfe5f8265998ca986ed1006c2635b5fbb354c4af14900950c81d42c39c1359e6">';
});
