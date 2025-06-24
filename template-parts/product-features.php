<?php
$product_features = !empty(get_post_meta(get_the_id(), 'product_features', true)) ? get_post_meta(get_the_id(), 'product_features', true) : array();

$feature_title = array_key_exists('feature_title', $product_features) ? $product_features['feature_title'] : '';
$feature_description = array_key_exists('feature_description', $product_features) ? $product_features['feature_description'] : '';
$feature_image = array_key_exists('feature_image', $product_features) ? $product_features['feature_image'] : '';
$feature_image = !empty($feature_image) ? $feature_image : get_template_directory_uri().'/assets/images/1-5x.png';
$product_width = array_key_exists('product_width', $product_features) ? $product_features['product_width'] : '';
$product_height = array_key_exists('product_height', $product_features) ? $product_features['product_height'] : '';
$product_thicknes = array_key_exists('product_thicknes', $product_features) ? $product_features['product_thicknes'] : '';
$feature_screen = array_key_exists('feature_screen', $product_features) ? $product_features['feature_screen'] : '';
$feature_power = array_key_exists('feature_power', $product_features) ? $product_features['feature_power'] : '';
$feature_camera = array_key_exists('feature_camera', $product_features) ? $product_features['feature_camera'] : '';
$feature_weight = array_key_exists('feature_weight', $product_features) ? $product_features['feature_weight'] : '';
$feature_sim = array_key_exists('feature_sim', $product_features) ? $product_features['feature_sim'] : '';
?>
<div class="container">
	<div class="product-features-section">
		<div class="features-heading">
			<h2 class="product-feature-title align-center section-title"><?php echo esc_html($feature_title); ?></h2>
			<p class="style-paragraph align-center"><?php echo $feature_description; ?></p>
		</div>
		<div class="product-features">
			<div class="feature-image-area">
				<div class="feature-image">
					<span class="product-width"><?php echo esc_html($product_width); ?></span>
					<span class="product-thicknes"><?php echo esc_html($product_thicknes); ?></span>
					<span class="product-height"><?php echo esc_html($product_height); ?></span>
					<img src="<?php echo esc_url($feature_image); ?>" alt="">
				</div>
			</div>
			<div class="feature-content-area">
				<div class="feature-contents">
					<ul>
						<li><span class="feature-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/screen.png" alt=""></span><span class="feature-text"><?php echo esc_html($feature_screen); ?></span></li>
						<li><span class="feature-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/power.png" alt=""></span><span class="feature-text"><?php echo esc_html($feature_power); ?></span></li>
						<li><span class="feature-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/camera.png" alt=""></span><span class="feature-text"><?php echo esc_html($feature_camera); ?></span></li>
						<li><span class="feature-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/weight.png" alt=""></span><span class="feature-text"><?php echo esc_html($feature_weight); ?></span></li>
						<li><span class="feature-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sim.png" alt=""></span><span class="feature-text"><?php echo esc_html($feature_sim); ?></span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>