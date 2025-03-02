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
}
add_action('init', 'yourfone_init');

/* Archive wrapper start */
function yourfone_output_content_wrapper(){
	if( is_product() ){
		echo '<div id="main"><div class="container-fluid">';
	}else{
		echo '<div id="main"><div class="container">';
	}
}

/* Archive wrapper end */
function yourfone_output_content_wrapper_end(){
	echo '<div><div>';
}

/* Customize the product title in the product loop */
function woocommerce_template_loop_product_title() {
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

/* Add color before title in product loop */
function yourfone_add_color_attribute_before_title(){
	$parse_str = parse_url(get_the_permalink());
	$str = $parse_str['query'];
	parse_str($str, $attributes);
	
	if( array_key_exists('attribute_pa_color', $attributes) ){
		echo '<div class="loop-color-wrapper"><span class="attr-color"></span><span class="attr-color-text">'.esc_html($attributes['attribute_pa_color']).'</span></div>';
	}
}

/* Add condition and add to cart button after title in product loop */
function yourfone_add_condition_attribute_after_title(){
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
