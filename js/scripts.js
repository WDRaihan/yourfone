jQuery(document).ready(function(){
	jQuery('li.variable-item').on('click', function(){
		var description = jQuery(this).attr('attribute-description');
		jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').html(description);
	});
	
	//Init slick slider
	jQuery('.yourfone_product_slider').each(function(){
		var target = jQuery(this).find('ul.products');
		var columns = jQuery(this).attr('slider-columns');
		var wrapper = jQuery(this);
		
		target.on('init',function(event, slick){
			wrapper.show();
		});
		target.slick({
			slidesToShow: columns,
			arrows: true,
			rows: 1,
			responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: columns,
				}
			  }, {
				breakpoint: 600,
				settings: {
					slidesToShow: 3,
				}
			  }, {
				breakpoint: 300,
				settings: {
					slidesToShow: 2,
				}
		  	}],
		});
		
	});
	
});

