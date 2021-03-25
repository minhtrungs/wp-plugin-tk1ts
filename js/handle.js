$(document).ready(function($){	
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

	$('.tlp-add-new').click(function(){
		$('.tlp-loading').show();
		$.post( ajaxUrl, {
			action: "get_new_info",
		}).done(function( data ) {
			$('#tlp-handle-info').remove();
			$('#tlp-form-info').after('<div id ="tlp-handle-info">' + data + '</div>');
			$('#tlp-handle-info').remove();
			$('.tlp-loading').hide();
		});
	});

	$('#tlp-form-info').on("submit", function(event){
		$("#tlp-submit-info").attr("disabled", true);		
		$('.tlp-notice-info').html('');
		$('.tlp-loading').show();
		event.preventDefault();
		var formData = new FormData();
		formData.append('action', "handle_info");
		formData.append('tlp_id', $('.tlp-id').val());
		formData.append('tlp_ma_so', $('.tlp-ma-so').val());
		formData.append('tlp_ho_ten', $('.tlp-ho-ten').val());
		formData.append('tlp_gioi_tinh', $('.tlp-gioi-tinh').val());
		var ngay_sinh = $('.tlp-ngay-sinh').val();
		if(moment(ngay_sinh, 'DD/MM/YYYY', true).isValid()){
			var tlp_ngay_sinh = moment(ngay_sinh, 'DD/MM/YYYY').add(1, 'days').format();
		}else if(ngay_sinh=='') var tlp_ngay_sinh = 0;
		else var tlp_ngay_sinh = 9999;
		formData.append('tlp_ngay_sinh', tlp_ngay_sinh);
		formData.append('tlp_phuong_xa', $('.tlp-phuong-xa').val());
		formData.append('tlp_quan_huyen', $('.tlp-quan-huyen').val());
		formData.append('tlp_tinh_thanh', $('.tlp-tinh-thanh').val());
		formData.append('tlp_cmnd', $('.tlp-cmnd').val());
		formData.append('tlp_muc_tien', $('.tlp-muc-tien').val());
		formData.append('tlp_phuong_thuc', $('.tlp-phuong-thuc').val());
		formData.append('tlp_noi_kcb', $('.tlp-noi-kcb').val());
		formData.append('tlp_noi_dung', $('.tlp-noi-dung').val());
		formData.append('tlp_ho_so', $('.tlp-ho-so').val());
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: formData,
			cache: false,
			processData: false, 
			contentType: false,
			success:function(data) {
				$('#tlp-handle-info').remove();
				$('#tlp-form-info').after('<div id ="tlp-handle-info">' + data + '</div>');
				$('#tlp-handle-info').remove();
				$("#tlp-submit-info").attr("disabled", false);
				$('.tlp-loading').hide();
			},
		});
	});

	$('#tlp-search-key').on("submit", function(event){
		$('#btn-load-more').attr('disabled', false);
		$('.tlp-loading').show();
		event.preventDefault();
		var formData = new FormData();
		formData.append('action', "tlp_search_key");
		formData.append('search_key', $('.search-key').val());
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: formData,
			cache: false,
			processData: false, 
			contentType: false,
			success:function(data) {
				$('#tlp-table-body').empty();
				$('#tlp-table-body').html(data);
				$('.tlp-loading').hide();
			},
		});
	});

	$('.search-donvi').change(function(){
		$('.tlp-loading').show();
		$('#btn-load-more').attr('disabled', false);
		var search_donvi = $('.search-donvi').val();
		$.post( ajaxUrl, {
			action: "tlp_search_donvi",
			search_donvi: search_donvi,
			paged: 0
		}).done(function( data ) {
			$('#tlp-table-body').empty();
			$('#tlp-table-body').html(data);
			$('.tlp-loading').hide();
		});
	});

	$('#tlp-form-import').on("submit", function(event){
		event.preventDefault();
		$('.tlp-notice-import').html('');
		$('.tlp-error-import').html('');
		$("#tlp-submit-import").attr("disabled", true);
		$('.tlp-loading').show();
		var file_upload = $('#tlp-upload-file')[0].files[0];
		var formData = new FormData();
		formData.append('file_upload', file_upload);
		formData.append('action', 'tlp_import_excel');
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: formData,
			cache: false,
			processData: false, 
			contentType: false,
			success:function(data) {
				$('#tlp-handle-import').remove();
				$('#tlp-form-import').after('<div id ="tlp-handle-import">' + data + '</div>');
				$('#tlp-handle-import').remove();
				$("#tlp-submit-import").attr("disabled", false);
				$('.tlp-loading').hide();
			},
		});
	});

	$('#tlp-form-export').on("submit", function(event){
		event.preventDefault();
		$('.tlp-notice-export').html('');
		$('.tlp-error-export').html('');
		$("#tlp-submit-export").attr("disabled", true);
		$('.tlp-loading').show();
		var formData = new FormData();
		formData.append('export_donvi', $('.tlp-export-donvi').val());
		formData.append('action', 'tlp_export_excel');
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: formData,
			cache: false,
			processData: false, 
			contentType: false,
			success:function(data) {
				window.open(data, '_blank');
				$('.tlp-loading').hide();
				$("#tlp-submit-export").attr("disabled", false);
			},
		});
	});
});
