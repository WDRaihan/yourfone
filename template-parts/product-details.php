<div class="product-details-section">
	<div class="details-heading">
		<h2 class="product-details-title align-left section-title"><?php echo esc_html(get_post_meta(get_the_id(), 'details_sec_title', true)); ?></h2>
	</div>
	<div class="product-details">
		<?php $product_details = !empty(get_post_meta(get_the_id(),'product_details',true)) ? get_post_meta(get_the_id(),'product_details',true) : array(); ?>
		<div class="details-contents">
			<?php if( !empty( array_filter($product_details) ) ): ?>
			<?php foreach( $product_details as $title=>$description ): ?>
			<ul>
				<li><span class="details-title"><?php echo esc_html($title); ?></span><span class="details-text"><?php echo esc_html($description); ?></span></li>
			</ul>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>