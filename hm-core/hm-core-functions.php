<?php
/**
 * Create The HM Help Hub
 **/

function hm_tutorial_video_menu() {
	add_menu_page(
		__( 'HM Help Hub', 'help-hub' ),
		__( 'HM Help Hub', 'help-hub' ),
		'manage_options',
		'hm-help-hub',
		'hm_help_hub_contents',
		'https://hewittmatthews.co.uk/wp-content/uploads/2022/06/white-favicon.png',
		3
	);
}

add_action( 'admin_menu', 'hm_tutorial_video_menu' );


function hm_help_hub_contents() {
	
	get_template_part('template-parts/admin/tutorial-videos'); 
	
}

function hh_video_mail(){
$to = 'web@hewittmatthews.co.uk';
$subject = 'HelpHub Video request on ' . $_POST['client'];
$body = $_POST['message'];
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );
echo "Your video request has been sent to the HM team and we'll be in touch shortly.";
die;
}
add_action("wp_ajax_hh_video_mail", "hh_video_mail");
add_action("wp_ajax_nopriv_hh_video_mail", "hh_video_mail");

function hh_support_mail(){
$to = 'web@hewittmatthews.co.uk';
$subject = 'HelpHub Support request on ' . $_POST['client'];
$body = $_POST['message'];
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );
echo "Your support request has been sent to the HM team and we'll be in touch shortly.";
die;
}
add_action("wp_ajax_hh_support_mail", "hh_support_mail");
add_action("wp_ajax_nopriv_hh_support_mail", "hh_support_mail");

/*****************************************************************************************************
 * DEV ONLY -- Everything below this box and above the next one can be deleted on launch -- DEV ONLY *
 *****************************************************************************************************/

/**
 * Create The HM Launch Portal
 **/

function hm_launch_portal_menu() {
	add_menu_page(
		__( 'Launch Portal', 'launch-portal' ),
		__( 'Launch Portal', 'launch-portal' ),
		'manage_options',
		'hm-launch-portal',
		'hm_launch_portal_contents',
		'https://hewittmatthews.co.uk/wp-content/uploads/2022/06/white-favicon.png',
		4
	);
}

add_action( 'admin_menu', 'hm_launch_portal_menu' );


function hm_launch_portal_contents() {
	
	get_template_part('template-parts/admin/launch-portal'); 
	
	$current_user = wp_get_current_user();
	$allowed_roles = array('administrator');
	
	if( !array_intersect($allowed_roles, $current_user->roles ) ) {
		$to = 'reece@hewittmatthews.co.uk';
		$subject = $current_user->user_login . ' has accessed the Launch Portal';
		$message = 'No content required';
		wp_mail( $to, $subject, $message );
	}

}

function lp_mail(){
$to = 'reece@hewittmatthews.co.uk';
$subject = 'Task marked as completed on ' . $_POST['client'];
$body = $_POST['task'];
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );
echo 'Task Marked as completed. Hewitt Matthews have been notified and will review the changes.';
die;
}
add_action("wp_ajax_lp_mail", "lp_mail");
add_action("wp_ajax_nopriv_lp_mail", "lp_mail");

add_role(
	'client',
	'Client',
	array(
		'read' => true,
		'edit_posts' => false,
		'delete_posts' => false,
		// Add the capability to access the specified pages
		'manage_options' => true,
		'hm_launch_portal' => true,
		'index' => true,
		'hm_help_hub' => true,
	)
);

if ( !is_user_logged_in() && !is_login() ) {		

	wp_redirect( '/wp-login.php' );
	exit;
	
} 

function redirect_client_to_lp_if_no_access() {
	
	$user = wp_get_current_user();

	if ( in_array( 'client', (array) $user->roles ) && !is_admin() ) {

		if(!get_field('enable_frontend_access', 'user_' . $user->ID)) {

			// Redirect the user to the 'Launch Portal' page
			wp_redirect( admin_url( 'admin.php?page=hm-launch-portal' ) );
			exit;

		}
	}
	
}

add_action( 'init', 'redirect_client_to_lp_if_no_access' );

function remove_dashboard_widgets_for_clients() {
    if ( current_user_can( 'client' ) ) {
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    }
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets_for_clients' );

/*****************************************************************************************************
 * DEV ONLY -- Everything above this box and below the last one can be deleted on launch -- DEV ONLY *
 *****************************************************************************************************/

// Enable this on launch then remove once user role is deleted
//remove_role('client');

function add_dashboard_styles() {
    // Get the current user
    $user = wp_get_current_user();
 
    // Check if the user has the 'client' role
    if ( in_array( 'client', (array) $user->roles ) ) {		
		?>

		<style>

			ul#adminmenu li:nth-child(n + 5),
			li#wp-admin-bar-breeze-topbar,
			#wp-admin-bar-wp-logo,
			.index-php #screen-meta-links {
				display: none;
			}

		</style>

		<?php
		
    } ?>

		<style>
			
			.postbox h2 {
				border-left: solid 5px rgb(43 236 211);
			}
			
			.postbox .inside h2.hm-title {
				padding: 0 0.5em;
				margin-left: -0.85em;
			}
			
			.postbox .inside:has(.hm-title) {
				padding-left: 1.5em;
			}
			
			.postbox a.btn {
				display: inline-block;
				padding: 0.5em 1em;
				background-color: rgb(43 236 211);
				color: #000;
				font-weight: 400;
				font-size: 19px;
				text-decoration: none;
			}

			.postbox a.btn:hover {
				text-decoration: underline;
			}

		</style>
		
		
	<?php
}
add_action( 'admin_head', 'add_dashboard_styles' );


function remove_events_and_news_widget() {
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'remove_events_and_news_widget' );

/**
 * Disable Default code for CPT
 **/
function disable_cptdivi(){
	remove_action( 'wp_enqueue_scripts', 'et_divi_replace_stylesheet', 99999998 );
}
add_action('init', 'disable_cptdivi');


//Limit length of text function
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]);
    }
    return $text;
}

/**
 *	This will hide the Divi "Project" post type.
 */
add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );
function mytheme_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}

//Console Log Helper Function
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

////Add HM logo to login page
function my_login_logo_one() { 
	?> 
	<style type="text/css"> 
	body.login div#login h1 a {
		 background-image: url(<?= get_stylesheet_directory_uri() ?>/assets/HM%20Logo-RGB%20Charcoal.svg);
			padding-bottom: 30px;
			background-size: 200px;
			width: 100%;
			background-position: center center;
	}
	</style>
	 <?php 
	}
	
	function custom_loginlogo_url($url) {
			 return 'https://www.hewittmatthews.co.uk/';
	}
	
	add_action( 'login_enqueue_scripts', 'my_login_logo_one' );
	add_filter( 'login_headerurl', 'custom_loginlogo_url' );
	
	//HelpHub Notification
	function hm_helphub_admin_notice() {
		global $pagenow;
		
		if($pagenow == "edit.php") : ?>
			<div class="notice notice-info">
				<p>Having Trouble? Check out the <a href="admin.php?page=hm-help-hub">HM HelpHub</a> to request a tutorial video from our team.</p>
			</div>
		<?php endif;
	}
	add_action('admin_notices', 'hm_helphub_admin_notice');
	
	// Admin footer modification
	function remove_footer_admin () 
	{
		echo '<span id="footer-thankyou">Developed by <a href="https://www.hewittmatthews.co.uk/" target="_blank">HewittMatthews</a></span>';
	}
	 
	add_filter('admin_footer_text', 'remove_footer_admin');
	
	add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
		
	function my_custom_dashboard_widgets() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget('custom_help_widget', ' ', 'hm_dashboard_help');
		wp_add_dashboard_widget('hm_ads_widget', ' ', 'hm_ads_widget');
		if ( current_user_can( 'client' ) ) {
			wp_add_dashboard_widget('launch_portal_widget', ' ', 'hm_lp_widget');
		}
	}
	 
	function hm_dashboard_help() { ?>
		<h2 class="hm-title">Help Hub</h2>
		<p>The Hewitt Matthews HelpHub is a video library where you can learn how to use the <?= get_bloginfo('name') ?> website. We've included an couple of introduction videos to get you started, however, you can request bespoke videos from the HM team whenever you need them.</p>
		<a href="/wp-admin/admin.php?page=hm-help-hub" class="btn">View the HelpHub</a>
	<?php }
	
	function hm_lp_widget() { ?>
		<h2 class="hm-title">The Launch Portal</h2>
		<p>During development of the <?= get_bloginfo('name') ?> website, you'll have access to the Launch Portal to help you keep track of developent.</p>
		<p>You'll be able to see estimated progress, track where we are in the development cycle, see if there are any outstading items we need from you and even see which members of the HM team are working on the project.</p>
		<a href="/wp-admin/admin.php?page=hm-launch-portal" class="btn">View the Launch Portal</a>
	<?php }

	function hm_ads_widget() { ?>
		<h2 class="hm-title">Digital Marketing Services</h2>
		<p>As well as building websites, Hewitt Matthews are experts in digital marketing.</p>
		<p>If you're interested in finding out more, book a call with our team using the button below.</p>
		<a href="https://meetings-eu1.hubspot.com/reece-matthews/" class="btn">Book a call</a>
	<?php }

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

// Add Theme Settings menu option

function hm_theme_settings_init() {
    register_setting( 'hm_theme_settings_group', 'site_max_width' );
    register_setting( 'hm_theme_settings_group', 'site_width' );
    register_setting( 'hm_theme_settings_group', 'site_logo' );
    register_setting( 'hm_theme_settings_group', 'site_color_1' );
    register_setting( 'hm_theme_settings_group', 'site_color_2' );
    register_setting( 'hm_theme_settings_group', 'site_color_3' );
    register_setting( 'hm_theme_settings_group', 'site_color_4' );
    register_setting( 'hm_theme_settings_group', 'site_color_5' );
    register_setting( 'hm_theme_settings_group', 'site_color_6' );
}
add_action( 'admin_init', 'hm_theme_settings_init' );

function hm_theme_options_page() {
    get_template_part('hm-theme/hm-theme-settings'); 
}

// Register menu item
function hm_theme_settings_menu() {
    add_options_page(
        'Theme Options',
        'Theme Options',
        'manage_options',
        'hm_theme_options_page',
        'hm_theme_options_page'
    );
}
add_action( 'admin_menu', 'hm_theme_settings_menu' );


// Get Image ID from URL utility Function
function getImageIdByUrl( $url )
{
    global $wpdb;

    // If the URL is auto-generated thumbnail, remove the sizes and get the URL of the original image
    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

    $image = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));

    if(!empty($image))
    {
        return $image[0];
    }

    return false;
}

?>