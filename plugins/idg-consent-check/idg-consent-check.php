<?php

/** 
 * @wordpress-plugin
 * Plugin Name:       idg-consent-check
 * Plugin URI:        https://info.idg.se/
 * Description:       This plugin loads the external 'IDG Consent plugin' that displays a popup modal for the visitor to grant och revoke consent for personalised ads. 'IDG Consent check' will supply several JS functions with callbacks that will fire when consent is set. Also include pixel functions to add pixels to posts and more. 
 * Version:           1.0.7
 * Author:            Felix
 * Text Domain:       idg_consent_check
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_IDG_CONSENT_CHECK_VERSION', '1.0.6' );


// Add scripts and script global config
add_action('wp_enqueue_scripts', 'idg_consent_add_scripts');
function idg_consent_add_scripts() {

	// Register consent script
	wp_register_script( 'idg_consent_check', plugin_dir_url( __FILE__ ) . 'js/idg_consent_check.js', array(), PLUGIN_IDG_CONSENT_CHECK_VERSION );

	// Add the plugin global settings as a javascript object
	$idg_consent_check_setting = array(
		// Get option value or use 'csw' as default
		'consent_project' 				=> (empty(esc_attr(get_option('idg_consent_project')))) ? 'csw' : esc_attr(get_option('idg_consent_project')),
		'consent_domain' 				=> esc_attr(get_option('idg_consent_domain', '')),
		'consent_response_box_message' 	=> esc_attr(get_option('idg_consent_response_box_message', '')),
		'consent_response_box' 			=> (bool)(!empty(esc_attr(get_option('idg_consent_response_box')))) ? true : false,
		'consent_disable_modal' 		=> (bool)(!empty(esc_attr(get_option('idg_consent_disable_modal')))) ? true : false,
		'plugin_version' 				=> PLUGIN_IDG_CONSENT_CHECK_VERSION,
	);
	wp_localize_script( 'idg_consent_check', 'idg_consent_check_setting', $idg_consent_check_setting );

	// Enqueued script with localized data.
	wp_enqueue_script( 'idg_consent_check' );



	// Register the global pixels script
	wp_register_script( 'idg_consent_check_pixels', plugin_dir_url( __FILE__ ) . 'js/idg_consent_check_pixels.js', array('idg_consent_check'), PLUGIN_IDG_CONSENT_CHECK_VERSION );

	// Add the pixel settings as javascript object
	$idg_consent_check_pixels = array(
		'facebook' => esc_attr(get_option('idg_consent_facebook_pixel')),
		'linkedin' => esc_attr(get_option('idg_consent_linkedin_pixel')),
		'comscore' => esc_attr(get_option('idg_consent_add_comscore_pixel')),
		'plugin_version' => PLUGIN_IDG_CONSENT_CHECK_VERSION,
	);
	wp_localize_script( 'idg_consent_check_pixels', 'idg_consent_check_pixels', $idg_consent_check_pixels );

	// Enqueued script with localized data.
	wp_enqueue_script( 'idg_consent_check_pixels' );

}








// Create settings page in admin menu
add_action('admin_menu', 'idg_consent_check_add_settings_page');

function idg_consent_check_add_settings_page() {
    // Add a new submenu under Settings:  
    add_options_page('IDG Consent settings and pixels', 'IDG Consent settings and pixels', 'manage_options', 'idg_consent_check_settings', 'idg_consent_check_settings_page');

    //call register settings function
	add_action( 'admin_init', 'idg_consent_check_register_settings' );

}


function idg_consent_check_register_settings() {
	//register our settings
	register_setting( 'idg_consent_check_setting', 'idg_consent_project' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_domain' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_disable_modal' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_hide_posts_meta_box' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_hide_pages_meta_box' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_response_box' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_response_box_message' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_facebook_pixel' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_linkedin_pixel' );
	register_setting( 'idg_consent_check_setting', 'idg_consent_add_comscore_pixel' );
}


// mt_settings_page() displays the page content for the Test Settings submenu
function idg_consent_check_settings_page() {
	?>
		<div class="wrap">
		<h1>IDG Consent plugin settings and pixels</h1>

		<form method="post" action="options.php">
		    <?php settings_fields( 'idg_consent_check_setting' ); ?>
		    <?php do_settings_sections( 'idg_consent_check_setting' ); ?>

		    <h2>IDG Consent plugin settings</h2>
		    <fieldset>
				<fieldset>
					<legend>window.IDG_CONFIGURATION.consent_project = </legend>
					<input type="text" name="idg_consent_project" value="<?php echo esc_attr( get_option('idg_consent_project') ); ?>" />
					<p>Will be set to <strong><em>csw</em></strong> as default value for wordpress, input here only to owerwrite, else leave empty!</p>
				</fieldset>

				<fieldset>
					<legend>window.IDG_CONFIGURATION.consent_domain = </legend>
					<input type="text" name="idg_consent_domain" value="<?php echo esc_attr( get_option('idg_consent_domain') ); ?>" />
					<p>Add domain only for non *.idg domains, else leave empty!</p>				
				</fieldset>

				<fieldset>
					<input type="checkbox" name="idg_consent_disable_modal" <?php echo (get_option('idg_consent_disable_modal'))? 'checked ' : ''; ?> /> Disable consent modal
				</fieldset>

				<fieldset>
					<input type="checkbox" name="idg_consent_response_box" <?php echo (get_option('idg_consent_response_box'))? 'checked ' : ''; ?> /> Show the response box after modal has been closed <br><br>
					Custom response message (optional): <input style="min-width:500px;" type="text" name="idg_consent_response_box_message" value="<?php echo esc_attr( get_option('idg_consent_response_box_message') ); ?>" /> 			
				</fieldset>

				<fieldset>
					<input type="checkbox" name="idg_consent_hide_posts_meta_box" <?php echo (get_option('idg_consent_hide_posts_meta_box'))? 'checked ' : ''; ?> />Hide meta box on posts
				</fieldset>

				<fieldset>
					<input type="checkbox" name="idg_consent_hide_pages_meta_box" <?php echo (get_option('idg_consent_hide_pages_meta_box'))? 'checked ' : ''; ?> />Hide meta box on pages
				</fieldset>


		    </fieldset>

		    </fieldset>

			<h2>Pixels</h2>

			<fieldset>
				<legend>Facebook pixel</legend>
				<input type="text" name="idg_consent_facebook_pixel" value="<?php echo esc_attr( get_option('idg_consent_facebook_pixel') ); ?>" /> Add facebook pixel id here to enable on all pages on consent = granted.
			</fieldset>

			<fieldset>
				<legend>LinkedIn pixel</legend>
				<input type="text" name="idg_consent_linkedin_pixel" value="<?php echo esc_attr( get_option('idg_consent_linkedin_pixel') ); ?>" /> Add linkedin_data_partner_id here to enable on all pages on consent = granted.
			</fieldset>

			<fieldset>
				<legend>Comscore pixel</legend>
				<input type="checkbox" name="idg_consent_add_comscore_pixel" <?php echo (get_option('idg_consent_add_comscore_pixel'))? 'checked ' : ''; ?> /> Add Comscore pixel (id = 6035308) to all pages on consent = granted.					
			</fieldset>

			</fieldset>
				
		    <?php submit_button(); ?>

		</form>
		</div>

		<style type="text/css">
			fieldset {border:1px solid #ddd;padding:10px;margin-bottom:20px;}
			fieldset > fieldset:last-child {margin-bottom: 5px;}
		</style>
	<?php 
}











/**
 * Add meta box to post admin page
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
add_action( 'add_meta_boxes_post', function ($post) {

	// Check if metabox should show or not
	if (!get_option('idg_consent_hide_posts_meta_box')) {
		add_meta_box( 'idg_consent_post_meta_box', __( 'IDG Consent retargeting pixel/iframe/scripts', 'idg_consent_check' ), 'idg_consent_build_meta_box', null, 'side', 'low' );
	}

});


add_action( 'add_meta_boxes_page', function ($post) {

	// Check if metabox should show or not
	if (!get_option('idg_consent_hide_page_meta_box')) {
		add_meta_box( 'idg_consent_post_meta_box', __( 'IDG Consent retargeting pixel/iframe/scripts', 'idg_consent_check' ), 'idg_consent_build_meta_box', null, 'side', 'low' );
	}

});


/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function idg_consent_build_meta_box( $post ) {

	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'idg_consent_post_meta_box_nonce' );

	// retrieve the idg_consent_pixel_dc_ui current value
	$current_idg_consent_pixel_dc_ui = get_post_meta( $post->ID, 'idg_consent_pixel_dc_ui', true );

	// retrieve the idg_consent_pixel_dc_seg current value
	$current_idg_consent_pixel_dc_seg = get_post_meta( $post->ID, 'idg_consent_pixel_dc_seg', true );

	// retrieve the idg_consent_iframe_name current value
	$current_idg_consent_iframe_name = get_post_meta( $post->ID, 'idg_consent_iframe_name', true );

	// retrieve the idg_consent_iframe_src current value
	$current_idg_consent_iframe_src = get_post_meta( $post->ID, 'idg_consent_iframe_src', true );

	// retrieve the idg_consent_manual_script_tag current value
	$current_idg_consent_manual_script_tag = get_post_meta( $post->ID, 'idg_consent_manual_script_tag', true );


	?>
	<div id="idg_consent_post_meta_box" class='inside <?=(get_option('idg_consent_hide_posts_meta_box'))? ' hideMetaBox ' : ''; ?>'>

		<p>Add a tracking pixel or iframe here:</p>

		<fieldset>
			<legend><strong>Pixel</strong></legend>
			<span title="(Optional) If empty, the default value will be used /8456/DFPAudiencePixel">dc_iu =</span>
			<input type="text" name="idg_consent_pixel_dc_ui" placeholder="Add network ID (8456)" value="<?php echo $current_idg_consent_pixel_dc_ui; ?>" /> 
			<br>
			<span title="May look like this: 123456789">dc_seg =</span>
			<input type="text" name="pixel_dc_seg" placeholder="Add segment ID" value="<?php echo $current_idg_consent_pixel_dc_seg; ?>" /> 
			<p class="desc">Note: <strong>dc_iu</strong> is the same as the network ID. <strong>8456</strong> Will be used as default if this field is left empty.</p>
		 </fieldset>

		<fieldset>
		  	<legend><strong>iframe</strong></legend>
			<span title="(OPTIONAL) May look like this: Trade Desk Tracking - IDG.SE_CIO Governance_retargeting">name =</span>
			<input type="text" name="iframe_name" placeholder="Add iframe name" value="<?php echo $current_idg_consent_iframe_name; ?>" /> 
			<br>
			<span title="May look like this: //insight.adsrvr.org/tags/1v5bd06/9t7rlf8/iframe">src =</span>
			<input type="text" name="iframe_src" placeholder="Add iframe src" value="<?php echo $current_idg_consent_iframe_src; ?>" /> 
		</fieldset>
		<fieldset>
		  	<legend><strong>Extra javascript</strong> (without &lt;script&gt;-tag)</legend>
			<textarea rows="4" cols="32" name="manual_script"><?php echo $current_idg_consent_manual_script_tag; ?></textarea>
			<p class="desc">You can add manual tracking scripts here, just make sure they are correct. Note, the script will run inside the <abbr title="IDG_CONSENT_CHECK.onGranted(function(){ /*code*/ });">onGranted</abbr> function when consent is granted.</p>
		</fieldset>

		<style type="text/css">
			#idg_consent_post_meta_box {padding:0}
			#idg_consent_post_meta_box ::placeholder {color:#ccc;}
			#idg_consent_post_meta_box .desc {color:#999; font-style:italic;}
			#idg_consent_post_meta_box > fieldset {border:1px solid #ddd;padding:10px;margin-bottom:20px;}
			#idg_consent_post_meta_box > fieldset > fieldset:last-child {margin-bottom: 5px;}
			#idg_consent_post_meta_box fieldset > span[title] {width:55px;display:inline-block;}
			#idg_consent_post_meta_box span {text-decoration: underline dotted;}
		</style>

	</div>
	<?php
}


/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
add_action( 'save_post', 'idg_consent_save_meta_box_data' );
function idg_consent_save_meta_box_data( $post_id ) {

	// verify meta box nonce
	if ( !isset( $_POST['idg_consent_post_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['idg_consent_post_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
  	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}


	// store custom fields values

	// pixel_dc_ui string
	if ( isset( $_REQUEST['idg_consent_pixel_dc_ui'] ) ) {
		update_post_meta( $post_id, 'idg_consent_pixel_dc_ui', sanitize_text_field( $_POST['idg_consent_pixel_dc_ui'] ) );
	}

	// pixel_dc_seg string
	if ( isset( $_REQUEST['pixel_dc_seg'] ) ) {
		update_post_meta( $post_id, 'idg_consent_pixel_dc_seg', sanitize_text_field( $_POST['pixel_dc_seg'] ) );
	}

	// iframe_name string
	if ( isset( $_REQUEST['iframe_name'] ) ) {
		update_post_meta( $post_id, 'idg_consent_iframe_name', sanitize_text_field( $_POST['iframe_name'] ) );
	}

	// iframe_src string
	if ( isset( $_REQUEST['iframe_src'] ) ) {
		update_post_meta( $post_id, 'idg_consent_iframe_src', sanitize_text_field( $_POST['iframe_src'] ) );
	}

	// idg_consent_manual_script_tag string
	if ( isset( $_REQUEST['manual_script'] ) ) {
		update_post_meta( $post_id, 'idg_consent_manual_script_tag', sanitize_text_field( $_POST['manual_script'] ) );
	}
}




// Small help function
function endsWith($haystack, $needle) {
	$length = strlen($needle);
	return $length === 0 || (substr($haystack, -$length) === $needle);
}

/** 
* Adds the tracking pixels to the posts
*/
add_action( 'wp_footer', 'idg_consent_add_pixel_scripts' );
function idg_consent_add_pixel_scripts() { 

	if(is_single() || is_page()) { 

		global $post;

		// retrieve the idg_consent_pixel_dc_ui current value
		$idg_consent_pixel_dc_ui = trim(get_post_meta( $post->ID, 'idg_consent_pixel_dc_ui', true ));

		// retrieve the idg_consent_pixel_dc_seg current value
		$idg_consent_pixel_dc_seg = trim(get_post_meta( $post->ID, 'idg_consent_pixel_dc_seg', true ));

		// retrieve the idg_consent_iframe_name current value
		$idg_consent_iframe_name = trim(get_post_meta( $post->ID, 'idg_consent_iframe_name', true ));

		// retrieve the idg_consent_iframe_src current value
		$idg_consent_iframe_src = trim(get_post_meta( $post->ID, 'idg_consent_iframe_src', true ));

		// retrieve the idg_consent_manual_script_tag current value
		$idg_consent_manual_script_tag = get_post_meta( $post->ID, 'idg_consent_manual_script_tag', true );


		// Insert tracking pixel
		if(!empty($idg_consent_pixel_dc_seg)) {
			?>
			<script>
				IDG_CONSENT_CHECK.insertPixel({
					'dc_iu':'<?=$idg_consent_pixel_dc_ui;?>',
					'dc_seg':'<?=$idg_consent_pixel_dc_seg;?>',
				});
			</script>
			<?php
		}

		// Insert tracking iframe
		if(!empty($idg_consent_iframe_src)) {
			?>
			<script>
				IDG_CONSENT_CHECK.insertIframe({
					'name':'<?=$idg_consent_iframe_name;?>',
					'src':'<?=$idg_consent_iframe_src;?>',
				});
			</script>
			<?php
		}

		// Insert manual script
		if(!empty($idg_consent_manual_script_tag)) {
			?>
			<script>
				IDG_CONSENT_CHECK.onGranted(function() {
					<?=$idg_consent_manual_script_tag;?>
				});
			</script>
			<?php
		}

	}
}







/**
 * Shortcode that inserts a retargeting pixel that will load on consent granted
 */
add_shortcode( 'retargeting_pixel', function ( $atts, $content = null) {
	$atts = shortcode_atts(array(
		'network_id' => '',
		'segment_id' => '',
		'ppid'		 => ''
	), $atts, 'retargeting_pixel' );

	// Insert tracking pixel that will run on consent = granted
	if(!empty($atts['segment_id'])) {
		return	"<script>IDG_CONSENT_CHECK.insertPixel({'dc_ui':'".$atts['network_id']."','dc_seg':'".$atts['segment_id']."'})</script>";
	} 
	else {
		return '';
	}

});


/**
 * Shortcode that inserts a iframe tracker that will load on consent granted
 */
add_shortcode( 'insert_iframe', function ( $atts, $content = null) {
	$atts = shortcode_atts(array(
		'name' => '',
		'src' => '',
	), $atts, 'insert_iframe' );

	// Insert tracking pixel that will run on consent = granted
	if(!empty($atts['src'])) {
		return	"<script>IDG_CONSENT_CHECK.insertIframe({'name':'".$atts['name']."','src':'".$atts['src']."'})</script>";
	} 
	else {
		return '';
	}

});


/**
 * Shortcode that inserts a facebook pixel that will load on consent granted
 */
add_shortcode( 'facebook_pixel', function ( $atts, $content = null) {
	$atts = shortcode_atts(array(
		'id' => '',
	), $atts, 'facebook_pixel');

	// Insert tracking pixel that will run on consent = granted
	if(!empty($atts['id'])) {
		return	"<script>IDG_CONSENT_CHECK.insertPixelFacebook('".$atts['id']."')</script>";
	}
});

/**
 * Shortcode that inserts a facebook pixel that will load on consent granted
 */
add_shortcode( 'linkedin_pixel', function ( $atts, $content = null) {
	$atts = shortcode_atts(array(
		'id' => '',
	), $atts, 'linkedin_pixel');

	// Insert tracking pixel that will run on consent = granted
	if(!empty($atts['id'])) {
		return	"<script>IDG_CONSENT_CHECK.insertPixelLinkedin('".$atts['id']."')</script>";
	}
});



/**
 * Shortcode that will insert a link with a popoup to the cookiesettings modal
 */
add_shortcode( 'idg_consent_modal_link', function ( $atts) {
	$atts = shortcode_atts(array('text' => ''), $atts, 'idg_consent_modal_link' );
	$text = ($atts['text'] === '') ? 'cookieinställningar' : $atts['text'];
	return '<a href="https://info.idg.se/integritet" target="_blank" class="idg-consent-modal-link" onclick="event.preventDefault(); IDG_CONSENT_PLUGIN.provide_consent_modal_expand();">'.$text.'</button>';
});



/**
 * Add the facebook and Linkedin pixels as addons in WP Bakery page buider
 */
add_action('init', function () {
	if(function_exists('vc_map') && is_admin() ) {

		// Facebook Pixel
		vc_map(array(
			"name" 				=> "Facebook-pixel",
			"base" 				=> "facebook_pixel",
			"icon"	 			=> "icon-wpb-balloon-facebook-left",
			"description" 		=> "Lägger in en Facebook pixel",
			"show_settings_on_create" => true,
			"class" 			=> "vc-facebook-pixel",
			"category" 			=> "IDG Event",
			'weight' 			=> 100,
			"params" 			=> array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => 'Facebook Pixel ID',
					"param_name" => "id",
					"value" => '',
					"description" => 'Ange ID för Facebook-pixeln som du vill läsa in. Denna kommer bara läsas in när besökaren tackat ja till cookies och personliga annonser.',
					"admin_label" => true
			))
		));

		// Linkedin pixel
		vc_map(array(
			"name" 				=> "Linkedin-:pixel",
			"base" 				=> "linkedin_pixel",
			"icon"	 			=> "",
			"description" 		=> "Lägger in en Linkedin pixel",
			"show_settings_on_create" => true,
			"class" 			=> "vc-linkedin-pixel",
			"category" 			=> "IDG Event",
			'weight' 			=> 100,
			"params" 			=> array(array(
					"type" => "textfield",
					"class" => "",
					"heading" => 'Linkedin partner ID',
					"param_name" => "id",
					"value" => '',
					"description" => 'Ange partner ID för Linkedin-pixeln som du vill läsa in. Denna kommer bara läsas in när besökaren tackat ja till cookies och personliga annonser.',
					"admin_label" => true
			))
		));


		// Linkedin pixel
		vc_map(array(
			"name" 				=> "iframe tracker",
			"base" 				=> "insert_iframe",
			"icon"	 			=> "",
			"description" 		=> "Lägger in en osynlig iframe för att kunna tracka besökaren.",
			"show_settings_on_create" => true,
			"class" 			=> "vc-iframe_tracker",
			"category" 			=> "IDG Event",
			'weight' 			=> 100,
			"params" 			=> array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => 'Namn',
					"param_name" => "name",
					"value" => '',
					"description" => 'Lägg till ett namn för att identifiera iframen, detta skrivs även ut i name-attributet.',
					"admin_label" => true
				), 
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => 'Iframe src',
					"param_name" => "src",
					"value" => '',
					"description" => 'Ange iframens url som läggs in i src-attributet. Denna kommer läsas in när besökaren tackat ja till cookies och personliga annonser.',
					"admin_label" => true
				)
			)
		));
	}
}, 9);

