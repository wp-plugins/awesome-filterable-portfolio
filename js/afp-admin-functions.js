/* MEDIA UPLOADER */
jQuery(document).ready(function($){
	$('#thumbnail').click(function(e) {
		e.preventDefault();
		var thumb = wp.media({ 
			title: 'Upload Thumbnail',
			multiple: false
		}).open().on('select', function(e){
			var thumb_url = thumb.state().get('selection').first().toJSON().url;
			$('#thumbnail_adr').val(thumb_url);
			});
		return false;
	});
	
	$('#image').click(function(e) {
		e.preventDefault();
		var image = wp.media({ 
			title: 'Upload Image',
			multiple: false
		}).open().on('select', function(e){
			var image_url = image.state().get('selection').first().toJSON().url;
			$('#image_adr').val(image_url);
			});
		return false;
	});
	
});

/* DATEPICKER */
jQuery(document).ready(function($){
	$('#date').datepicker({ showAnim: 'fadeIn' });
});