$(document).ready(function() {
//datepicker for text input
 $(function() {
   //datepicker for expire select input		
  $('input#GiftExpireDateHidden').datepick({showOn: 'both', buttonImageOnly: true,
  buttonImage: 'js/datepicker/calendar-green.gif'});
 });

//populating the series of select input from text input
  $("input#GiftExpireDateHidden").change(function() {
      var dt = $("input#GiftExpireDateHidden").val();
      var dtArray = Array();
      dtArray = dt.split('/');
	  
	  $('#CardExpireDateMonth').val(dtArray[0]);
      $('#CardExpireDateYear').val(dtArray[2]);
  });
 });