$(document).ready(function() {
	//datepicker for text input
	$(function() {
		//datepicker for textfield input
		$('input.datepicker').datepick({
			showOn: 'both', 
			buttonImageOnly: true,
			buttonImage: 'js/datepicker/calendar-green.gif'
		});
		//datepicker for select input
		$('input.datepicker.select_a').datepick({
			showOn: 'button', 
			buttonImageOnly: true, 
			buttonImage: 'js/datepicker/calendar-green.gif'
		});
	});
	//populating the series of select input from text input
	$("input.select_a").change(function() {
		var dt = $("input.select_a").val();
		var dtArray = Array();
		dtArray = dt.split('/');
		$('#popupDatepickerMonth').val(parseInt(dtArray[0], 10));
		$('#popupDatepickerDay').val(parseInt(dtArray[1], 10));
		$('#popupDatepickerYear').val(parseInt(dtArray[2], 10));
	});
});
