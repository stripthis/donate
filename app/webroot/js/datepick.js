$(document).ready(function() {
//datepicker for text input
 $(function() {
	   //datepicker for expire select input		
	  $('input#GiftExpireDateHidden').datepick({showOn: 'both', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	   //datepicker for end select input		
	  $('input#GiftEndDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  //datepicker for start select input
	  $('input#GiftStartDate').datepick({showOn: 'button', 
		 buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
	    //datepicker for end select input		
	  $('input#AppealsStartDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  //datepicker for start select input
	  $('input#AppealsEndDate').datepick({showOn: 'button', 
		 buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
 });

	//populating the series of select input from text input
	  $("input#GiftExpireDateHidden").change(function() {
		  var dt = $("input#GiftExpireDateHidden").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#CardExpireDateMonth').val(dtArray[0]);
		  $('#CardExpireDateYear').val(dtArray[2]);
	  });
	  //populating the series of select input from text input
	  $("input#GiftStartDate").change(function() {
		  var dt = $("input#GiftStartDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#GiftStartDateMonthMonth').val(dtArray[0]);
		  $('#GiftStartDateDayDay').val(dtArray[1]);
		  $('#GiftStartDateYearYear').val(dtArray[2]);
	  });
	 
	 //populating the series of select input from text input
	  $("input#GiftEndDate").change(function() {
		  var dt = $("input#GiftEndDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#GiftEndDateMonthMonth').val(dtArray[0]);
		  $('#GiftEndDateDayDay').val(dtArray[1]);
		  $('#GiftEndDateYearYear').val(dtArray[2]);
	  });
	    //populating the series of select input from text input
	  $("input#AppealsStartDate").change(function() {
		  var dt = $("input#AppealsStartDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#AppealsStartDateMonthMonth').val(dtArray[0]);
		  $('#AppealsStartDateDayDay').val(dtArray[1]);
		  $('#AppealsStartDateYearYear').val(dtArray[2]);
	  });
	 
	 //populating the series of select input from text input
	  $("input#AppealsEndDate").change(function() {
		  var dt = $("input#AppealsEndDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#AppealsEndDateMonthMonth').val(dtArray[0]);
		  $('#AppealsEndDateDayDay').val(dtArray[1]);
		  $('#AppealsEndDateYearYear').val(dtArray[2]);
	  });
 });