<?php
/**
 * Plugin Name: HM Theme Settings
 * Plugin URI: http://example.com
 * Description: A custom settings page for my plugin.
 * Version: 1.0
 * Author: Your Name
 * Author URI: http://example.com
 * License: GPL2
 */
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'hm_theme_settings_group' ); ?>
		<?php do_settings_sections( 'hm_theme_options_page' ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="site_max_width">Site Max Width</label></th>
					<td><input name="site_max_width" type="number" id="site_max_width" value="<?php echo esc_attr( get_option( 'site_max_width', 1250 ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_width">Site Width</label></th>
					<td><input name="site_width" type="number" id="site_width" value="<?php echo esc_attr( get_option( 'site_width', 80 ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_logo">Site Logo</label></th>
					<td>
						<input name="site_logo" type="text" id="site_logo" value="<?php echo esc_attr( get_option( 'site_logo' ) ); ?>" />
						<button class="button" id="select-site-logo">Select Image</button>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_1">Site Colour Palette 1</label></th>
					<td><input name="site_color_1" type="color" id="site_color_1" value="<?php echo esc_attr( get_option( 'site_color_1', '#000000' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_2">Site Colour Palette 2</label></th>
					<td><input name="site_color_2" type="color" id="site_color_2" value="<?php echo esc_attr( get_option( 'site_color_2', '#ffffff' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_3">Site Colour Palette 3</label></th>
					<td><input name="site_color_3" type="color" id="site_color_3" value="<?php echo esc_attr( get_option( 'site_color_3' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_4">Site Colour Palette 4</label></th>
					<td><input name="site_color_4" type="color" id="site_color_4" value="<?php echo esc_attr( get_option( 'site_color_4' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_5">Site Colour Palette 5</label></th>
					<td><input name="site_color_5" type="color" id="site_color_5" value="<?php echo esc_attr( get_option( 'site_color_5' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="site_color_6">Site Colour Palette 6</label></th>
					<td><input name="site_color_6" type="color" id="site_color_6" value="<?php echo esc_attr( get_option( 'site_color_6' ) ); ?>" /></td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>

<script>
    jQuery(document).ready(function($){
        $('#select-site-logo').on('click', function(e){
            e.preventDefault();
            var image = wp.media({
                title: 'Select Site Logo',
                multiple: false
            }).open().on('select', function(e){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#site_logo').val(image_url);
            });
        });
    });
</script>