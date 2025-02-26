jQuery(document).ready(function(){
	//Add group item
	jQuery('.details-add-more').on('click', function(e){
		e.preventDefault();
		
		var groupItem = `<div class="group-item">
				<a href="#" title="Remove this group item" class="remove-ietm">Remove</a>
				<div class="item-title">
					<label class="field-label">Title</label>
					<input type="text" class="regular-text" name="details_title[]" placeholder="Enter product details title">
				</div>
				<div class="item-description">
					<label class="field-label">Description</label>
					<input type="text" class="regular-text" name="details_description[]" placeholder="Enter product details description">
				</div>
			</div>`;
		jQuery('.meta-field-group .field-groups').append(groupItem);
	});
	
	//remove group item
	jQuery(document).on('click', '.group-item a.remove-ietm', function(e){
		e.preventDefault();
		
		jQuery(this).parent('.group-item').remove();
	});
	
	//Upload media
	var mediaUploader;
	jQuery('.upload-feature-image').click(function(e) {
		e.preventDefault();

		if (mediaUploader) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media({
			title: 'Select',
			button: {
				text: 'Select'
			},
			multiple: false
		});

		mediaUploader.on('select', function() {
			var attachment = mediaUploader.state().get('selection').first().toJSON();
			jQuery('.meta-field-group #feature-image').val(attachment.url);
			//$('#custom_media_preview').attr('src', attachment.url).show();
		});

		mediaUploader.open();
	});

});