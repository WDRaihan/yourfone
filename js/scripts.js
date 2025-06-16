jQuery(document).ready(function(){
	/*Single product page script*/
	jQuery('li.variable-item').on('click', function(){
		var description = jQuery(this).attr('attribute-description');
		
		if( description == '' ){
			jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').hide();
		}else{
			jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').html(description).show();
		}
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
				breakpoint: 1199,
				settings: {
					slidesToShow: 6,
				}
			  }, {
				breakpoint: 1024,
				settings: {
					slidesToShow: 5,
				}
			  }, {
				breakpoint: 767,
				settings: {
					slidesToShow: 4,
				}
			  }, {
				breakpoint: 500,
				settings: {
					slidesToShow: 3,
				}
			  }, {
				breakpoint: 390,
				settings: {
					slidesToShow: 2,
				}
		  	}],
		});
		
	});
	
	/*Mobile menu*/
	jQuery('#masthead .mobile-menu .menu-toggle .toggle-icon').on('click', function(){
		jQuery('#masthead .mobile-menu #site-navigation').addClass('active-mobile-nav');
	});
	jQuery('#masthead .mobile-menu .nav-close').on('click', function(){
		jQuery('#masthead .mobile-menu #site-navigation').removeClass('active-mobile-nav');
	});
	
	jQuery('.mobile-menu #site-navigation ul#primary-menu li.menu-item a span.submenu-arrow').on('click', function(e){
		e.preventDefault();
		jQuery(this).parents('li.menu-item-has-children').find('ul.sub-menu').toggle();
		jQuery('.up, .down',this).toggle();
	});
});

jQuery(window).on('load', function(){
	jQuery('li.variable-item').each(function(){
		var description = jQuery(this).attr('attribute-description');
		
		if( description == '' ){
			jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').hide();
		}else{
			jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').html(description).show();
		}
	});
});