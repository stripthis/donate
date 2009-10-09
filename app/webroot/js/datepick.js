$(document).ready(function() {
//datepicker for text input
 $(function() {
   //datepicker for end select input		
  $('input#GiftEndDate').datepick({showOn: 'button', buttonImageOnly: true,
  buttonImage: 'js/datepicker/calendar-green.gif'});
  //datepicker for start select input
  $('input#GiftStartDate').datepick({showOn: 'button', 
     buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
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
});