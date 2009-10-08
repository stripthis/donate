$(document).ready(function() {
	//datepicker for text input
	$(function() {
		//datepicker for textfield input
		$('input#popupDatepicker').datepick({
			showOn: 'both', buttonImageOnly: true,
			buttonImage: 'js/datepicker/calendar-green.gif'
		});
		//datepicker for select input
		$('input#a').datepick({
			showOn: 'button', 
			buttonImageOnly: true, 
			buttonImage: 'js/datepicker/calendar-green.gif'
		});
	});
	//populating the series of select input from text input
	$("input#a").change(function() {
		var dt = $("input#a").val();
		var dtArray = Array();
		dtArray = dt.split('/');
		$('#a_month').val(parseInt(dtArray[0], 10));
		$('#a_day').val(parseInt(dtArray[1], 10));
		$('#a_year').val(parseInt(dtArray[2], 10));
	});
});
