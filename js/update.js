jQuery(document).ready(function($){
	$('.tlp-detail').click(function(){
		$('.tlp-loading').show();
		var row_id = $(this).attr('val');
		$.post( ajaxUrl, {
			action: "get_update_info",
			row_id: row_id
		}).done(function( data ) {
			$('#tlp-handle-info').remove();
			$('#tlp-form-info').after('<div id ="tlp-handle-info">' + data + '</div>');
			$('#tlp-handle-info').remove();
			$('.tlp-loading').hide();
		});
	});
});
