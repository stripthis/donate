$(document).ready(function() {
//datepicker for text input
 $(function() {
	   //datepicker for expire select input		
	  $('input#GiftExpireDateHidden').datepick({showOn: 'both', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	   //datepicker for end select input		
	  $('input#GiftEndDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  //datepicker imnage for Gift
	  $('input#GiftStartDate').datepick({showOn: 'button', 
		 buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
	    //datepicker image for Appeal		
	  $('input#AppealsStartDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  $('input#AppealsEndDate').datepick({showOn: 'button', 
		 buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
	  //datepicker image for Transaction		
	  $('input#TransactionStartDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  $('input#TransactionEndDate').datepick({showOn: 'button', 
		 buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
	    //datepicker image for Log		
	  $('input#LogStartDate').datepick({showOn: 'button', buttonImageOnly: true,
	  buttonImage: 'js/datepicker/calendar-green.gif'});
	  $('input#LogEndDate').datepick({showOn: 'button', 
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
	  //populating selected date for Gift
	  $("input#GiftStartDate").change(function() {
		 populateStartSelect(this.id);
	  });
	  $("input#GiftEndDate").change(function() {
		 populateEndSelect(this.id);
	  });
	  
	    //populating selected date for Appeals
	  $("input#AppealsStartDate").change(function() {
		 populateStartSelect(this.id);
	  });
	  $("input#AppealsEndDate").change(function() {
		populateEndSelect(this.id);
	  });
	  
	  //populating selected date for Transaction
	  $("input#TransactionStartDate").change(function() {
			populateStartSelect(this.id);
	  });
	  $("input#TransactionEndDate").change(function() {
			populateEndSelect(this.id);
	  });
	  
	  //populating selected date for Log
	  $("input#LogStartDate").change(function() {
			populateStartSelect(this.id);
	  });
	  $("input#LogEndDate").change(function() {
			populateEndSelect(this.id);
	  });
	  
	  
	//populating the series of select input from text input	for Start date
	  function populateStartSelect(id) {
		  var pageName=id.split('StartDate', 1);
		  var dt = $("input#"+pageName+"StartDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#'+pageName+'StartDateMonthMonth').val(dtArray[0]);
		  $('#'+pageName+'StartDateDayDay').val(dtArray[1]);
		  //Append year option to select input if that year option in not available in select dropdown list
		  appendYearOption(pageName+'StartDateYearYear', dtArray[2]);
		  $('#'+pageName+'StartDateYearYear').val(dtArray[2]);
	  }
	 //populating the series of select input from text input for End date 
	   function populateEndSelect(id) {
		  var pageName=id.split('EndDate', 1);
		  var dt = $("input#"+pageName+"EndDate").val();
		  var dtArray = Array();
		  dtArray = dt.split('/');
		  
		  $('#'+pageName+'EndDateMonthMonth').val(dtArray[0]);
		  $('#'+pageName+'EndDateDayDay').val(dtArray[1]);
		  //Append year option to select input if that year option in not available in select dropdown list
		  appendYearOption(pageName+'EndDateYearYear', dtArray[2]);
		  $('#'+pageName+'EndDateYearYear').val(dtArray[2]);
		  
	  }
	  function appendYearOption(id, year){
		   var yearAvailable = false;
		   $('#'+id+' option').each(function() { 
		  		if(year == $(this).text()) {
		  			yearAvailable = true;	
				}
		  });
		  if(yearAvailable == false){
			$('#'+id).append('<option value='+year+'>'+year+'</option>');
		  }
	  }
 });