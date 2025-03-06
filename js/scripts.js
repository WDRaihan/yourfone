jQuery(document).ready(function(){
	jQuery('li.variable-item').on('click', function(){
		var description = jQuery(this).attr('attribute-description');
		jQuery(this).parents('td.value.woo-variation-items-wrapper').find('.attribute-description').html(description);
	});
});