<?php
/*
Template name: Category - New Battery
*/
get_header();
?>
<main id="primary" class="site-main">
	
	<div class="category-page-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/new-battery-banner.png)">
		<div class="banner-content">
			<div class="banner-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/new-battery-icon.png" alt="new-battery-icon">
			</div>
			<div class="banner-title"><h1><?php echo get_the_title() ?: esc_html__('New battery'); ?></h1></div>
		</div>
	</div>
	
	<div class="category-page-content">
		<div class="container">
			<div class="woocommerce">
				<?php

				$product_query = new WP_Query( array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_type',
							'field'    => 'slug',
							'terms'    => 'variable', // Only get variable products
						),
					)
				) );
				if ( $product_query->have_posts() ) {
					while ( $product_query->have_posts() ) {
						$product_query->the_post();
						$product_id = get_the_ID();
						$product_title = get_the_title();

						/* Display single variations*/

						$query_args = array(
							'post_type'      => 'product_variation',
							'post_status'    => 'publish',
							'posts_per_page' => -1,
							'paged'          => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
							'post_parent'    => $product_id,
							'meta_query'     => array(
								array(
									'key'     => 'attribute_pa_battery',
									'value'   => 'new',
									'compare' => '=',
								)
							)
						);

						$query = new WP_Query( $query_args );

						if ( $query->have_posts() ) {
							echo '<h2>'.$product_title.'</h2>';

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

							woocommerce_product_loop_start();

							while ( $query->have_posts() ) {
								$query->the_post();
								wc_get_template_part( 'content', 'product' );
							}

							woocommerce_product_loop_end();
							//woocommerce_pagination();
							wp_reset_postdata();
							wc_reset_loop();

						}

						/* End Display single variations*/

					}
					wp_reset_postdata();
				}
			?>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();