<?php
/**
 * Register a menu page.
 */
function yourfone_register_theme_option_menu_page(){
	add_menu_page( 
		__( 'Theme Option', 'textdomain' ),
		'Theme Option',
		'manage_options',
		'theme_option',
		'yourfone_theme_options_menu',
		'dashicons-admin-generic',
		6
	); 
}
add_action( 'admin_menu', 'yourfone_register_theme_option_menu_page' );

add_action('admin_init', 'yourfone_register_settings');

function yourfone_register_settings() {
    register_setting('yourfone_theme_options_group', 'product_background_image');
    register_setting('yourfone_theme_options_group', 'product_badge_url');
}

function yourfone_theme_options_menu() {
    ?>
<div class="wrap">
	<h1>YourFone Theme Options</h1>
	<form method="post" action="options.php">
		<?php
            settings_fields('yourfone_theme_options_group');
            do_settings_sections('yourfone_theme_options_group');
            ?>
			<table class="form-table">
				<tbody>
					<tr><h2>Product Page Settings</h2></tr>
					<tr>
						<th><label for="">Product Image Backgound</label></th>
						<td><input type="text" name="product_background_image" class="regular-text" value="<?php echo esc_url(get_option('product_background_image')); ?>" placeholder="Enter product background image URL"></td>
					</tr>
					<tr>
						<th><label for="">Product Badge</label></th>
						<td><input type="text" name="product_badge_url" class="regular-text" value="<?php echo esc_url(get_option('product_badge_url')); ?>" placeholder="Enter product badge URL"></td>
					</tr>
				</tbody>
			</table>
		<p><input type="submit" class="button button-primary" value="Save"></p>
	</form>
</div>
<?php
}