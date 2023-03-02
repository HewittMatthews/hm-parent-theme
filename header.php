<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hm_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	
	<?php //HM Theme Site Options
	
	$site_max_width = get_option( 'site_max_width', 1250 );
	$site_width = get_option( 'site_width', 80 );
	$site_logo = get_option( 'site_logo' );
	$site_color_1 = get_option( 'site_color_1', '0 0 0' );
	$site_color_2 = get_option( 'site_color_2', '255 255 255' );
	$site_color_3 = get_option( 'site_color_3' );
	$site_color_4 = get_option( 'site_color_4' );
	$site_color_5 = get_option( 'site_color_5' );
	$site_color_6 = get_option( 'site_color_6' );
	
	?>
	
	<style id="hm-root-styles">
	
		:root {
			--siteMaxWidth: <?= $site_max_width; ?>px;
			--siteWidth: <?= $site_width; ?>%;
			--colourOne: <?= $site_color_1 ?>;
			--colourTwo: <?= $site_color_2 ?>;
			--colourThree: <?= $site_color_3 ?>;
			--colourFour: <?= $site_color_4 ?>;
			--colourFive: <?= $site_color_5 ?>;
			--colourSix: <?= $site_color_6 ?>;
		}
	
	</style>
	
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hm-theme' ); ?></a>

	<header id="masthead" class="site-header">
		
		<div class="hm-row">
		
			<div class="site-branding">
				<?php
					echo wp_get_attachment_image( getImageIdByUrl($site_logo), "large", true, array( "loading" => "lazy" ) );
				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'hm-theme' ); ?></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			
		</div>
	</header><!-- #masthead -->
