<?php

/*Init hooks*/
function yourfone_init(){
	remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_before_main_content', 'yourfone_output_content_wrapper', 10);
	add_action('woocommerce_after_main_content', 'yourfone_output_content_wrapper_end', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	add_action('woocommerce_shop_loop_item_title', 'yourfone_add_color_attribute_before_title', 5);
	add_action('woocommerce_shop_loop_item_title', 'yourfone_add_condition_attribute_after_title', 15);
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
	add_action('woocommerce_before_variations_form', 'yourfone_template_single_title_and_price', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	add_filter('woo_variation_swatches_variable_item_custom_attributes', 'yourfone_variation_swatches_variable_item_custom_attributes', 10, 4);
	add_filter( 'woo_variation_swatches_html', 'yourfone_variation_swatches_html', 10, 4 );
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	add_action('woocommerce_after_single_product_summary', 'yourfone_output_product_features', 30);
	add_action('woocommerce_after_single_product_summary', 'yourfone_output_product_details', 35);
	add_action('woocommerce_after_single_product_summary', 'yourfone_output_related_products', 20);
	add_action('woocommerce_after_single_product_summary', 'yourfone_output_service_highlights', 25);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	add_action('woocommerce_after_shop_loop_item_title', 'yourfone_template_loop_price', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	add_action('woocommerce_before_single_product', 'yourfone_woo_product_image_bg', 10);
	add_action( 'woocommerce_after_add_to_cart_form', 'yourfone_echo_variation_info' );
	add_action( 'woocommerce_before_add_to_cart_quantity', 'yourfone_display_variation_info_before_addtocart', 10 );
	add_action( 'woocommerce_before_add_to_cart_quantity', 'yourfone_display_shipping_info_before_addtocart', 15 );
	add_action( 'woocommerce_after_add_to_cart_button', 'yourfone_display_shipping_info_after_addtocart', 10 );
	add_action( 'wp_ajax_yourfone_related_products_by_ajax', 'yourfone_related_products_by_ajax' );
	add_action( 'wp_ajax_nopriv_yourfone_related_products_by_ajax', 'yourfone_related_products_by_ajax' );
	add_filter( 'woocommerce_show_variation_price', '__return_true' );
}
add_action('init', 'yourfone_init');

/* Shortcode: Display variation as product card */
add_shortcode( 'single_variations', 'yourfone_single_variations_shortcode' );

function yourfone_single_variations_shortcode( $atts ) {

	// Parse shortcode attributes
	$atts = shortcode_atts( array(
		'attribute'    => '',
		'value'        => '',
		'attribute_2'  => '',
		'value_2'      => '',
	), $atts, 'single_variations' );

	$meta_query = array();

	// Add first attribute filter if provided
	if ( ! empty( $atts['attribute'] ) && ! empty( $atts['value'] ) ) {
		$meta_query[] = array(
			'key'     => 'attribute_' . sanitize_key( $atts['attribute'] ),
			'value'   => sanitize_text_field( $atts['value'] ),
			'compare' => '=',
		);
	}

	// Add second attribute filter if provided
	if ( ! empty( $atts['attribute_2'] ) && ! empty( $atts['value_2'] ) ) {
		$meta_query[] = array(
			'key'     => 'attribute_' . sanitize_key( $atts['attribute_2'] ),
			'value'   => sanitize_text_field( $atts['value_2'] ),
			'compare' => '=',
		);
	}

	$query_args = array(
		'post_type'      => 'product_variation',
		'post_status'    => 'publish',
		'posts_per_page' => 24,
		'paged'          => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
	);

	// Add meta_query if needed
	if ( ! empty( $meta_query ) ) {
		$query_args['meta_query'] = $meta_query;
	}

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() ) {
		ob_start();

		wc_setup_loop( array(
			'name'         => 'single_variations',
			'is_shortcode' => true,
			'is_search'    => false,
			'is_paginated' => true,
			'total'        => $query->found_posts,
			'total_pages'  => $query->max_num_pages,
			'per_page'     => $query->get( 'posts_per_page' ),
			'current_page' => max( 1, $query->get( 'paged', 1 ) ),
		) );

		echo '<div class="woocommerce">';
		woocommerce_output_content_wrapper();
		woocommerce_pagination();
		woocommerce_product_loop_start();

		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}

		woocommerce_product_loop_end();
		woocommerce_pagination();
		wp_reset_postdata();
		wc_reset_loop();
		woocommerce_output_content_wrapper();
		echo '</div>';

		return ob_get_clean();
	}

	return '';
}

/* Shortcode: Product slider */
add_shortcode( 'yourfone_product_slider', 'yourfone_product_slider_shortcode' );
function yourfone_product_slider_shortcode($atts) {
	$attributes = shortcode_atts( array(
		'ids' => '',
		'limit' => -1,
		'columns' => 5,
	), $atts );

	if( empty($attributes['ids']) ) return;
	
	$ids = explode(',', $attributes['ids']);
	
	$query = new WP_Query( array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => $attributes['limit'],
		'post__in' => $ids,
	));
	if ( $query->have_posts() ) {
		ob_start();
		echo '<div class="woocommerce yourfone_product_slider" style="display:none" slider-columns="'.$attributes['columns'].'">';
		echo '<ul class="products">';
		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		echo '</ul>';
		wp_reset_postdata();
		wc_reset_loop();
		echo '</div>';
		return ob_get_clean();
	}
	return;
}

/* Archive wrapper start */
function yourfone_output_content_wrapper(){
	if( is_shop() ){
		echo '<div id="main"><div class="container">';
	}
}

/* Archive wrapper end */
function yourfone_output_content_wrapper_end(){
	if( is_shop() ){
		echo '</div></div>';
	}
}

/* Customize the product title in the product loop */
function woocommerce_template_loop_product_title() {
	$product = wc_get_product(get_the_ID());
	$product_parent = $product->get_parent_id();
	
	if( $product_parent == 0 ){
		
		$product_permalink = !empty(get_post_meta( get_the_ID(), 'variation_url', true )) ? get_post_meta( get_the_ID(), 'variation_url', true ) : get_the_permalink();
		
		echo '<a href="' . esc_url( $product_permalink ) . '" class="product-default-loop-title woocommerce-LoopProduct-link woocommerce-loop-product__link">';
		echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>';
		echo '</a>';
		return;
	}
	
	$parse_str = parse_url(get_the_permalink());
	$str = $parse_str['query'];
	parse_str($str, $attributes);
	
	$html = '<div class="loop-title-wrapper">';
	$html .= '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	$html .= '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>';
	$html .= '</a>';
	
	if( array_key_exists('attribute_pa_capacity', $attributes) ){
		$term = get_term_by('slug', $attributes['attribute_pa_capacity'], 'pa_capacity');
		$html .= '<span class="attr-capacity">'.esc_html($term->name).'</span>';
	}
	
	$html .= '</div>';
	echo $html;
}

//Remove price from default product loop
function yourfone_template_loop_price(){
	$product = wc_get_product(get_the_ID());
	$product_parent = $product->get_parent_id();
	
	if( $product_parent != 0 ){
		woocommerce_template_loop_price();
	}
}

/* Add color before title in product loop */
function yourfone_add_color_attribute_before_title(){
	$product = wc_get_product(get_the_ID());
	$product_parent = $product->get_parent_id();
	
	if( $product_parent == 0 ){
		return;
	}
	
	$parse_str = parse_url(get_the_permalink());
	$str = $parse_str['query'];
	parse_str($str, $attributes);
	
	if( array_key_exists('attribute_pa_color', $attributes) ){
		$term = get_term_by('slug', $attributes['attribute_pa_color'], 'pa_color');
		$color = !empty(get_term_meta($term->term_id, 'product_attribute_color', true)) ? get_term_meta($term->term_id, 'product_attribute_color', true) : '#171E28';
		echo '<div class="loop-color-wrapper"><span class="attr-color" style="background:'.$color.'"></span><span class="attr-color-text">'.esc_html($attributes['attribute_pa_color']).'</span></div>';
	}
}

/* Add condition and add to cart button after title in product loop */
function yourfone_add_condition_attribute_after_title(){
	$product = wc_get_product(get_the_ID());
	$product_parent = $product->get_parent_id();
	
	if( $product_parent == 0 ){
		return;
	}
	
	$parse_str = parse_url(get_the_permalink());
	$str = $parse_str['query'];
	parse_str($str, $attributes);
	
	$html = '<div class="loop-condition-wrapper">';
	$html .= '<div class="attr-condition">';
	
	if( array_key_exists('attribute_pa_condition', $attributes) ){
		$html .= '<span class="condition-title">Condition: </span><span class="condition-text">'.esc_html($attributes['attribute_pa_condition']).'</span>';
	}
	
	$html .= '</div>';
	$html .= '<div class="custom-add-to-cart-btn">';
	$html .= '<a href="'.esc_url( get_the_permalink() ).'"><img src="'.get_template_directory_uri().'/assets/images/eye.png"></a>';
	$html .= '</div>';
	$html .= '</div>';
	echo $html;
}

/**
* Register Metabox
*/
function yourfone_add_product_details_meta_boxes(){
	add_meta_box( 'yourfone_product_features', __( 'Product Features','yourfone' ),'yourfone_product_features_callback', 'product' );
	add_meta_box( 'yourfone_product_details', __( 'Product Details','yourfone' ),'yourfone_product_details_callback', 'product' );
	add_meta_box( 'yourfone_product_slider_settings', __( 'Product Slider Setting','yourfone' ),'yourfone_product_slider_settings_callback', 'product' );
}
add_action('add_meta_boxes', 'yourfone_add_product_details_meta_boxes' );

/* Product features fields */
function yourfone_product_features_callback(){
	$product_features = !empty(get_post_meta(get_the_id(), 'product_features', true)) ? get_post_meta(get_the_id(), 'product_features', true) : array();
	
	$feature_title = array_key_exists('feature_title', $product_features) ? $product_features['feature_title'] : '';
	$feature_description = array_key_exists('feature_description', $product_features) ? $product_features['feature_description'] : '';
	$feature_image = array_key_exists('feature_image', $product_features) ? $product_features['feature_image'] : '';
	$product_width = array_key_exists('product_width', $product_features) ? $product_features['product_width'] : '';
	$product_height = array_key_exists('product_height', $product_features) ? $product_features['product_height'] : '';
	$product_thicknes = array_key_exists('product_thicknes', $product_features) ? $product_features['product_thicknes'] : '';
	$feature_screen = array_key_exists('feature_screen', $product_features) ? $product_features['feature_screen'] : '';
	$feature_power = array_key_exists('feature_power', $product_features) ? $product_features['feature_power'] : '';
	$feature_camera = array_key_exists('feature_camera', $product_features) ? $product_features['feature_camera'] : '';
	$feature_weight = array_key_exists('feature_weight', $product_features) ? $product_features['feature_weight'] : '';
	$feature_sim = array_key_exists('feature_sim', $product_features) ? $product_features['feature_sim'] : '';
	?>
	<div class="meta-field-group">
		<label class="field-label" for="feature-title"><?php echo esc_html('Title','yourfone'); ?></label>
		<input type="text" class="regular-text" name="feature_title" id="feature-title" value="<?php echo esc_html($feature_title); ?>">
	</div>
	
	<div class="meta-field-group">
		<label class="field-label" for="feature-description"><?php echo esc_html('Description','yourfone'); ?></label>
		<textarea name="feature_description" id="feature-description" class="regular-text" cols="30" rows="5"><?php echo esc_html($feature_description); ?></textarea>
	</div>
	
	<div class="meta-field-group">
		<label class="field-label" for="feature-image"><?php echo esc_html('Image','yourfone'); ?></label>
		<a href="#" class="button button-primary upload-feature-image">Upload</a><input type="url" class="" name="feature_image" id="feature-image" placeholder="Or Enter Image URL" value="<?php echo esc_url($feature_image); ?>">
	</div>
	
	<div class="meta-field-group">
		<label class="field-label"><?php echo esc_html('Product Dimensions ','yourfone'); ?></label>
		<span>Add dimensions of the product below</span>
	</div>
	<div class="field-groups">
		<div class="meta-field-group">
			<label class="field-label" for="product-width"><?php echo esc_html('Width','yourfone'); ?></label>
			<input type="text" class="regular-text" name="product_width" id="product-width" value="<?php echo esc_html($product_width); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="product-height"><?php echo esc_html('Height','yourfone'); ?></label>
			<input type="text" class="regular-text" name="product_height" id="product-height" value="<?php echo esc_html($product_height); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="product-thicknes"><?php echo esc_html('Thicknes','yourfone'); ?></label>
			<input type="text" class="regular-text" name="product_thicknes" id="product-thicknes" value="<?php echo esc_html($product_thicknes); ?>">
		</div>
	</div>
	
	<div class="meta-field-group">
		<label class="field-label"><?php echo esc_html('Features','yourfone'); ?></label>
		<span>Add basic features below</span>
	</div>
	<div class="field-groups">
		<div class="meta-field-group">
			<label class="field-label" for="feature-screen"><?php echo esc_html('Screen','yourfone'); ?></label>
			<input type="text" class="regular-text" name="feature_screen" id="feature-screen" value="<?php echo esc_html($feature_screen); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="feature-power"><?php echo esc_html('Power(Battery)','yourfone'); ?></label>
			<input type="text" class="regular-text" name="feature_power" id="feature-power" value="<?php echo esc_html($feature_power); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="feature-camera"><?php echo esc_html('Camera','yourfone'); ?></label>
			<input type="text" class="regular-text" name="feature_camera" id="feature-camera" value="<?php echo esc_html($feature_camera); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="feature-weight"><?php echo esc_html('Weight','yourfone'); ?></label>
			<input type="text" class="regular-text" name="feature_weight" id="feature-weight" value="<?php echo esc_html($feature_weight); ?>">
		</div>
		<div class="meta-field-group">
			<label class="field-label" for="feature-sim"><?php echo esc_html('SIM','yourfone'); ?></label>
			<input type="text" class="regular-text" name="feature_sim" id="feature-sim" value="<?php echo esc_html($feature_sim); ?>">
		</div>
	</div>
	
	<?php wp_nonce_field( 'product_features_nonce_action', 'product_features_nonce_action' ); ?>
	<?php
}

/* Product details fields */
function yourfone_product_details_callback(){
	?>
	<div class="meta-field-group">
		<label class="field-label" for="details-sec-title"><?php echo esc_html('Section Title','yourfone'); ?></label>
		<input type="text" class="regular-text" name="details_sec_title" id="details-sec-title" value="<?php echo esc_html(get_post_meta(get_the_id(), 'details_sec_title', true)); ?>">
	</div>
	<div class="meta-field-group">
		<label class="field-label"><?php echo esc_html('Details','yourfone'); ?></label>
		<span>Add product details below</span>
	</div>
	<?php
	$product_details = !empty(get_post_meta(get_the_id(),'product_details',true)) ? get_post_meta(get_the_id(),'product_details',true) : array();
	?>
	<div class="meta-field-group">
		<div class="field-groups">
			<?php if( !empty( array_filter($product_details) ) ): ?>
			<?php foreach( $product_details as $title=>$description ): ?>
			<div class="group-item">
				<a href="#" title="Remove this group item" class="remove-ietm">Remove</a>
				<div class="item-title">
					<label class="field-label"><?php echo esc_html('Title','yourfone'); ?></label>
					<input type="text" class="regular-text" name="details_title[]" placeholder="Enter product details title" value="<?php echo esc_html($title); ?>">
				</div>
				<div class="item-description">
					<label class="field-label"><?php echo esc_html('Description','yourfone'); ?></label>
					<input type="text" class="regular-text" name="details_description[]" placeholder="Enter product details description" value="<?php echo esc_html($description); ?>">
				</div>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div style="text-align:center"><a href="#" class="button details-add-more">+ Add More</a></div>
		<?php wp_nonce_field( 'product_details_nonce_action', 'product_details_nonce_action' ); ?>
	</div>
	
	<?php
}

//Save features
function yourfone_save_features_callback( $post_id ) {
	$postdata = wp_unslash( $_POST );
	
	//Save product features
	if ( ! isset( $_POST['product_features_nonce_action'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['product_features_nonce_action'], 'product_features_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( !isset( $_POST['post_type'] ) && 'product' != $_POST['post_type'] ) {
		return;
	}
		
	$feature_description = $_POST['feature_description'];
	$allowed_html = array(
		'br' => array(),
	);
	
	$feature_description = wp_kses( $feature_description, $allowed_html );
	
	$product_features = array(
		'feature_title' => sanitize_text_field($_POST['feature_title']),
		'feature_description' => $feature_description,
		'feature_image' => sanitize_url($_POST['feature_image']),
		'feature_screen' => sanitize_text_field($_POST['feature_screen']),
		'feature_power' => sanitize_text_field($_POST['feature_power']),
		'feature_camera' => sanitize_text_field($_POST['feature_camera']),
		'feature_weight' => sanitize_text_field($_POST['feature_weight']),
		'feature_sim' => sanitize_text_field($_POST['feature_sim']),
		'product_width' => sanitize_text_field($_POST['product_width']),
		'product_height' => sanitize_text_field($_POST['product_height']),
		'product_thicknes' => sanitize_text_field($_POST['product_thicknes']),
	);
	
	update_post_meta($post_id, 'product_features', $product_features);
	
	//Save product details
	if ( ! isset( $_POST['product_details_nonce_action'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['product_details_nonce_action'], 'product_details_nonce_action' ) ) {
		return;
	}
	
	update_post_meta($post_id, 'details_sec_title', sanitize_text_field($_POST['details_sec_title']));
	
	if($_POST['details_title']){
		$detail_titles = array_map( 'sanitize_text_field', wp_unslash($_POST['details_title']) );
		$detail_descriptions = array_map( 'sanitize_text_field', wp_unslash($_POST['details_description']) );
	}
	
	$details = [];
	foreach( $detail_titles as $k=>$detail_title ){
		$details[$detail_title] = $detail_descriptions[$k];
	}
	
	update_post_meta($post_id, 'product_details', $details);
}
add_action( 'save_post', 'yourfone_save_features_callback' );

/* Product slider settings */
function yourfone_product_slider_settings_callback(){
	?>
	<div class="meta-field-group">
		<label class="field-label" for="variation-url"><?php echo esc_html('Variation URL','yourfone'); ?></label>
		<input type="text" class="regular-text" name="variation_url" id="variation-url" value="<?php echo esc_html(get_post_meta(get_the_id(), 'variation_url', true)); ?>" placeholder="Enter a variation URL for the slider">
	</div>
	<?php wp_nonce_field( 'product_slider_settings_nonce_action', 'product_slider_settings_nonce_action' ); ?>
	<?php
}

/* Save slider settings */
add_action( 'save_post', 'yourfone_save_product_slider_settings' );
function yourfone_save_product_slider_settings($post_id){
	$postdata = wp_unslash( $_POST );
	
	//Save product features
	if ( ! isset( $_POST['product_slider_settings_nonce_action'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['product_features_nonce_action'], 'product_features_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( !isset( $_POST['post_type'] ) && 'product' != $_POST['post_type'] ) {
		return;
	}
	
	update_post_meta($post_id, 'variation_url', sanitize_text_field($_POST['variation_url']));
}

//Wrap title and price
function yourfone_template_single_title_and_price(){
	echo '<div class="single-title-price top-title">';
	echo '<div class="title-area">';
	woocommerce_single_variation();
	woocommerce_template_single_title();
	echo '<span class="selected-variations"></span>';
	echo '</div>';
	woocommerce_single_variation();
	echo '</div>';
}

//Add attribute description to the attributes in single product page
function yourfone_variation_swatches_variable_item_custom_attributes($html_attributes, $data, $attribute_type, $variation_data){
	$term_id = $data['term_id'];
	$description = get_term_field( 'description', $term_id );

	if ( ! is_wp_error( $description ) ) {
        $html_attributes['attribute-description'] = $description;
    } else {
        $html_attributes['attribute-description'] = ''; // or handle error differently
    }
	
	return $html_attributes;
}

//Add attribute description wrapper
function yourfone_variation_swatches_html($html, $args, $swatches_data, $obj){
	$html = $html;
	$html .= '<div class="attribute-description" style="display:none"></div>';
	return $html;
}

//Display product features on the single product page
function yourfone_output_product_features(){
	require_once 'template-parts/product-features.php';
}

//Display product details on the single product page
function yourfone_output_product_details(){
	require_once 'template-parts/product-details.php';
}

//Display related products on the single product page
function yourfone_output_related_products(){
	require_once 'template-parts/related-products.php';
}

//Display service highlights on the single product page
function yourfone_output_service_highlights(){
	require_once 'template-parts/service-highlights.php';
}

//Single product background
function yourfone_woo_product_image_bg(){
?>
<style>
	.product-image-col .product-image-bg {
		background-image: url(<?php echo esc_url(get_option('product_background_image')); ?>);
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		position: sticky;
		max-width: 100%;
		top: 0;
	}
	.woocommerce div.product .slick-slide::before {
		background-image: url(<?php echo esc_url(get_option('product_badge_url')); ?>);
	}
</style>
<?php
}

//Display selected variables on the single product page after title
function yourfone_echo_variation_info() {
	global $product;
	if ( ! $product->is_type( 'variable' ) ) return;
	?>
  	<script>
		
		/*let currentSlide = 0;
		let totalSlides = 0;
		let visibleSlides = 1;

		function initSlider() {
		  const track = document.querySelector('.yourfone_related_product_slider ul.products');
		  const slides = document.querySelectorAll('.yourfone_related_product_slider li.product');
		  totalSlides = slides.length;

		  const prevBtn = document.querySelector('.prev-btn');
		  const nextBtn = document.querySelector('.next-btn');

		  const maxIndex = Math.max(0, totalSlides - visibleSlides);

		  function updateSlider() {
			const shift = (100 / visibleSlides) * currentSlide;
			track.style.transform = `translateX(-${shift}%)`;
		  }

		  prevBtn.onclick = () => {
			if (currentSlide > 0) {
			  currentSlide--;
			  updateSlider();
			}
		  };

		  nextBtn.onclick = () => {
			if (currentSlide < maxIndex) {
			  currentSlide++;
			  updateSlider();
			}
		  };

		  currentSlide = 0;
		  updateSlider();
		}*/
		
		let currentSlide = 0;

		function getVisibleSlidesCount() {
		  if (window.innerWidth >= 1024) return 5;
		  if (window.innerWidth >= 768) return 3;
		  return 2;
		}

		function initSlider() {
		  const track = document.querySelector('.yourfone_related_product_slider ul.products');
		  const slides = document.querySelectorAll('.yourfone_related_product_slider li.product');
		  const prevBtn = document.querySelector('.prev-btn');
		  const nextBtn = document.querySelector('.next-btn');

		  if (!track || slides.length === 0) return;

		  function updateSlider() {
			const visibleSlides = getVisibleSlidesCount();
			const slideWidth = slides[0].offsetWidth;
			const maxIndex = Math.max(0, slides.length - visibleSlides);
			currentSlide = Math.min(currentSlide, maxIndex);

			const shift = currentSlide * slideWidth;
			track.style.transform = `translateX(-${shift}px)`;
		  }

		  prevBtn.onclick = () => {
			if (currentSlide > 0) {
			  currentSlide--;
			  updateSlider();
			}
		  };

		  nextBtn.onclick = () => {
			const visibleSlides = getVisibleSlidesCount();
			const maxIndex = Math.max(0, slides.length - visibleSlides);
			if (currentSlide < maxIndex) {
			  currentSlide++;
			  updateSlider();
			}
		  };

		  window.addEventListener('resize', () => {
			updateSlider();
		  });

		  updateSlider();
		}
		
		
		jQuery(document).on('found_variation', 'form.cart', function( event, variation ) {
			
			let attributeString = Object.values(variation.attributes)
			  .map(value => {
				// Replace hyphens with spaces
				let formatted = value.replace(/-/g, ' ');
				// Capitalize each word
				formatted = formatted.replace(/\b\w/g, char => char.toUpperCase());
				formatted = formatted.replace(/(\d+)\s*gb\b/gi, '$1 GB');
				return formatted;
			  })
			  .join(' | ');
			jQuery('.single-title-price .selected-variations').html(attributeString);
			
			var attributes = variation.attributes;
			var attributeCondition = attributes.attribute_pa_condition;
			var variationPrice = variation.display_price;
			
			jQuery.ajax({
				type: 'POST',
				url: yourfone_object.ajaxurl,
				data: {
					action: 'yourfone_related_products_by_ajax',
					condition: attributeCondition,
					price: variationPrice
				},
				success: function(response){
					//console.log(response);
					jQuery('.woo-related-products .yourfone_related_product_slider ul.products').html(response);
					initSlider();
					jQuery('.yourfone_related_product_slider').css('opacity','1');
				}
			});
			
		});
  	</script>
	<?php
}

//yourfone related products by ajax
function yourfone_related_products_by_ajax(){
	$condition = $_POST['condition'];
	$price = $_POST['price'];
	
	$target_price = $price;
	$min_price = $target_price - 100;
	$max_price = $target_price + 100;
	
	$query = new WP_Query( array(
		'post_type'      => 'product_variation',
		'post_status'    => 'publish',
		'posts_per_page' => 24,
		'paged'          => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'attribute_pa_condition',
				'value'   => $condition,
				'compare' => '=',
			),
			array(
				'key'     => '_price',
				'value'   => array( $min_price, $max_price ),
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC'
			),
		),
	) );
	
	echo yourfone_get_product_loop($query);
	die();
}

function yourfone_get_product_loop($query){
	if ( $query->have_posts() ) {
		ob_start();
		wc_setup_loop(
			array(
				'name' => 'single_variations',
				'is_shortcode' => true,
				'is_search' => false,
				'is_paginated' => true,
				'total' => $query->found_posts,
				'total_pages' => $query->max_num_pages,
				'per_page' => $query->get( 'posts_per_page' ),
				'current_page' => max( 1, $query->get( 'paged', 1 ) ),
			)
		);

		while ( $query->have_posts() ) {
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		wp_reset_postdata();
		wc_reset_loop();
		
		return ob_get_clean();
	}
}

function yourfone_display_variation_info_before_addtocart() {
	echo '<div class="single-title-price" style="padding:24px 0 24px 0;border:1px solid #ddd;border-left:0;border-right:0;margin:20px 0;"
>';
	echo '<div class="title-area">';
	woocommerce_single_variation();
	echo '<span class="selected-variations"></span>';
	echo '</div>';
	woocommerce_single_variation();
	echo '</div>';
}

function yourfone_display_shipping_info_before_addtocart() {
	echo '<div class="shipping-info-before-cart-btn">';
	echo '<p><span class="shipping-icon"><img src="'.get_template_directory_uri().'/assets/images/shipping-icon.png"></span>Ready to be picked up</p>';
	echo '</div>';
}

function yourfone_display_shipping_info_after_addtocart() {
	echo '<div class="shipping-info-after-cart-btn">';
	echo '<p>Pickup available at <b>Nerang Mall, Australia.</b><br>5A/7-27 Cayuga St, Nerang. (Next to Nerang AU Post)<br>Usually ready in 2 hours (during opening hours)</p>';
	echo '</div>';
	
	echo '<div class="box-info-after-cart-btn">';
	echo '<h2>Included in the box</h2>';
	echo '<p><span><img src="'.get_template_directory_uri().'/assets/images/pin.png" /></span>USB-A charging cable and SIM tray ejector tool.</p>';
	echo '</div>';
}

//Mini cart
function yourfone_mini_cart() { 
    echo '<div class="dropdown-menu yourfone_mini_cart dropdown-menu-mini-cart">';
        echo '<div>';
            echo '<div class="widget_shopping_cart_content">';
                woocommerce_mini_cart();
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
add_shortcode( 'yourfone_mini_cart', 'yourfone_mini_cart' );

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
function wc_refresh_mini_cart_count($fragments){
    ob_start();
    $items_count = WC()->cart->get_cart_contents_count();
    ?>
    <div id="mini-cart-count"><?php echo $items_count ? $items_count : '0'; ?></div>
    <?php
        $fragments['#mini-cart-count'] = ob_get_clean();
    return $fragments;
}

add_filter('woocommerce_available_variation', 'hide_out_of_stock_variations', 10, 3);

function hide_out_of_stock_variations($variation_data, $product, $variation) {
    if (!$variation->is_in_stock()) {
        return false; // This removes the variation from the dropdown.
    }
    return $variation_data;
}