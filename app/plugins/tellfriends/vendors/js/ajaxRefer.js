$(document).ready(function() {
   $("input#import").click(function() { 
			var email =$("#openinviterEmailBox").val();
			var pass = $("#openinviterPasswordBox").val();
			var provider =$("#openinviterProviderBox").val();
			//validating for blank input
			$("#errEmail").empty();
			$("#errPass").empty();
			var errors =0;
			if(email == ''){
			 	$("#errEmail").append("Please specify your Email.");
				errors++;
			}
			if(pass == ''){
			 	$("#errPass").append("Please specify your Password.");	
				errors++;
			}
			//ajax for getting contact list
			if(errors == 0){
				//$("#TB_window").parent().$("#contactList").empty();
				//$("#TB_window").parent().$("#contactList").append("<img src='img/loading.gif' height ='350px' width ='600px'/>");
				var xmlhttp = GetXmlHttpObject();
				if(xmlhttp){
					var encodedPass = $.base64Encode(pass);
					var url="tellfriends/tellfriends/contactList/"+email+"/"+encodedPass+"/"+provider;
					xmlhttp.open("POST",url,true);
					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState==4) {
							 var res = xmlhttp.responseText;
							 parent.tb_remove();  //closing thickbox
							 parent.$("#contactList").empty();
							 parent.$("#contactList").append(res);
						 }
					}
					xmlhttp.send(null);
				}
			}
   
 });
	//datepicker for text input
	$(function() {
		$('input#popupDatepicker').datepick({showOn: 'both', buttonImageOnly: true,
		buttonImage: 'js/datepicker/calendar-green.gif'});
		//datepicker for select input
		$('input#a').datepick({showOn: 'button', 
    	buttonImageOnly: true, buttonImage: 'js/datepicker/calendar-green.gif'});
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



function GetXmlHttpObject()
{
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	  }
	else if (window.ActiveXObject) {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	return xmlhttp;
}



function tellFriends(chckbox)
{
	var chckVal = chckbox.value;
	var emailList = $("#TellfriendReceiver").val();
	//appending email address of checked checkbox
	if(chckbox.checked == true){
		if(emailList == ''){
			$("#TellfriendReceiver").val(chckVal);
		} else {
			$("#TellfriendReceiver").val(emailList + "," +chckVal);
		}
	} else if(chckbox.checked == false) { //removing email address of unchecked checkbox
		var result = "";
		if(emailList.indexOf(chckVal) == 0){
			result = emailList.replace(chckVal, "");
		}else{
		     var replaceWith = ","+chckVal;
			 result = emailList.replace(replaceWith, "");
		}
		
		if(result.charAt(0) == ","){
			result = result.replace(",", "");
		}
		$("#TellfriendReceiver").val(result);
	}

}
