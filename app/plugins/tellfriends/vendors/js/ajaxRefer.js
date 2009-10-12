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
				$("#openinviter_login").hide();
				$("#contactList").empty();
				$("#contactList").show();
				$("#contactList").append("<img src='img/loading.gif' height ='350px' width ='600px'/>");
				var xmlhttp = GetXmlHttpObject();
				if(xmlhttp){
					var encodedPass = $.base64Encode(pass);
					var url="tellfriends/tellfriends/contactList/"+email+"/"+encodedPass+"/"+provider;
					xmlhttp.open("POST",url,true);
					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState==4) {
							 var res = xmlhttp.responseText;
							// parent.tb_remove();  //closing thickbox
							$("#contactList").empty();
							$("#contactList").append(res);
						 }
					}
					xmlhttp.send(null);
				}
			}
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
	var emailList = $("#openinviter_contact_list").val();
	//appending email address of checked checkbox
	if(chckbox.checked == true){
		if(emailList == ''){
			$("#openinviter_contact_list").val(chckVal);
		} else {
			$("#openinviter_contact_list").val(emailList + "," +chckVal);
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
		$("#openinviter_contact_list").val(result);
	}

}

function validate(){
	var emailList = $("#openinviter_contact_list").val();
	var yourEmail = $("#openinviterEmailBox").val();
	parent.tb_remove();
	var prevEmailList = parent.$("#TellfriendReceiver").val();
	if(prevEmailList == ''){
		var newEmailList  = emailList;
	} else {
		var newEmailList  = prevEmailList + "," + emailList;
	}
	parent.$("#TellfriendReceiver").val(newEmailList);
	parent.$("#TellfriendSender").val(yourEmail);
	
}
function backto(){
	$("#openinviter_login").show();
	$("#contactList").hide();
}