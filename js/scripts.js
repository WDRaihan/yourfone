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
	
	//Home page product slider
	jQuery(".yourfone_product_slider ul.products").owlCarousel({
		items: 8,
		navigation:true,
		slideSpeed: 300,
		paginationSpeed: 300,
		itemsDesktop: [1199,8],
		itemsDesktopSmall: [979,6],
		itemsTablet: [768,5],
		itemsMobile:[479,4],
		pagination: false,
		navigationText: ["←","→"]

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