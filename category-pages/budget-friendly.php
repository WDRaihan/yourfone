<?php
/*
Template name: Category - Budget Friendly
*/
get_header();
?>
<main id="primary" class="site-main">
	
	<div class="category-page-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/budget-friendly-banner.png)">
		<div class="banner-content">
			<div class="banner-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/budget-friendly-icon.png" alt="new-battery-icon">
			</div>
			<div class="banner-title"><h1><?php echo get_the_title() ?: esc_html__('Budget friendly'); ?></h1></div>
		</div>
	</div>
	
	<div class="category-page-content">
		<div class="container">
			<div class="woocommerce">
				<?php
				//Set budgets
				$budgets = array(
					'500' => array(401, 500),
					'400' => array(301, 400),
					'300' => array(10, 300),
				);

				if ( $budgets ) {
					foreach( $budgets as $budget=>$value ) {
						
						$budget_title = $budget;
						
						$min_price = $value[0];
						$max_price = $value[1];
						
						/* Display single variations*/
						
						$query_args = array(
							'post_type'      => 'product_variation',
							'post_status'    => 'publish',
							'posts_per_page' => -1,
							'paged'          => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
							'meta_query'     => array(
								array(
									'key'     => '_price',
									'value'   => array( $min_price, $max_price ),
									'compare' => 'BETWEEN',
									'type'    => 'NUMERIC'
								)
							)
						);

						$query = new WP_Query( $query_args );

						if ( $query->have_posts() ) {
							echo '<h2>Under '.wc_price($budget_title).'</h2>';

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
				}
			?>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();