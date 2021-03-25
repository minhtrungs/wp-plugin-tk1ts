jQuery(document).ready(function(jQuery){
    jQuery( "#tlp-username" ).attr( "placeholder", "Username" );
    jQuery( "#tlp-username" ).attr( "required", "required" );
    jQuery( "#tlp-password" ).attr("placeholder", "Password");
    jQuery( "#tlp-password" ).attr( "required", "required" );
});

;(function ($) { $.fn.datepicker.language['vi'] = {
    days: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
    daysShort: ['CN', 'Thứ2', 'Thứ3', 'Thứ4', 'Thứ5', 'Thứ6', 'Thứ7'],
    daysMin: ['CN', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7'],
    months: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
    monthsShort: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
    today: 'Hôm nay',
    clear: 'Xóa',
    dateFormat: 'mm/dd/yyyy',
    timeFormat: 'hh:ii aa',
    firstDay: 0
}; })(jQuery);

jQuery(function(){
	var ngaysinh = $('.tlp-ngay-sinh').datepicker().data('datepicker');
	ngaysinh.selectDate(new Date());
})