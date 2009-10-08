$(document).ready(function() {
	var _calendar_picture = '../img/icons/S/date.png';
	var _picker_class_input = 'input.datepicker';
	var _picker_class_select = 'input.datepicker.select_a';
	
	//datepicker for text input
	$(function() {
		//datepicker for textfield input
		$(_picker_class_input).datepick({
			showOn: 'both', 
			buttonImageOnly: true,
			buttonImage: _calendar_picture
		});
		//datepicker for select input
		$(_picker_class_select).datepick({
			showOn: 'button', 
			buttonImageOnly: true, 
			buttonImage: _calendar_picture
		});
	});
	//populating the series of select input from text input
	//@todo manage difference between dd/mm/yyyy and mm/dd/yyyy
	$(_picker_class_select).change(function() {
		var dt = $(_picker_class_select).val();
		var dtArray = Array();
		dtArray = dt.split('/');
		$('#popupDatepickerDay').val(parseInt(dtArray[1], 10));
		var month = parseInt(dtArray[0], 10);
		if(month < 10) month = '0' + month;
		$('#popupDatepickerMonth').val(month);
		$('#popupDatepickerYear').val(parseInt(dtArray[2], 10));
	});
	
	//populating text input from select input(s)
	//@todo manage difference between dd/mm/yyyy and mm/dd/yyyy
	$('#popupDatepickerDay').change(function() {
		update_from_select();
	});
	$('#popupDatepickerMonth').change(function() {
		update_from_select();
	});
	$('#popupDatepickerYear').change(function() {
		update_from_select();
	});
	function update_from_select() {
		var result = $('#popupDatepickerMonth').val();
		result += '/' + $('#popupDatepickerDay').val();
		result += '/' + $('#popupDatepickerYear').val();
		$(_picker_class_select).val(result);
	};
});
