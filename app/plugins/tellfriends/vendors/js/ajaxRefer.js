$(document).ready(function() {
   $("input#import").click(function() {
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp){
				var email =$("#openinviterEmailBox").val();
				var pass = $("#openinviterPasswordBox").val();
				var provider =$("#openinviterProviderBox").val();
			 
				var url="tellfriends/tellfriends/contactList/"+email+"/"+pass+"/"+provider;
				xmlhttp.open("POST",url,true);
				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4)
					 {
						 var res = xmlhttp.responseText;
						 $("#contactList").empty();
						 $("#contactList").append(res);
					 }
				}
				xmlhttp.send(null);
			}
   
 });

});



function GetXmlHttpObject()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
}



function tellFriends(chckbox)
{
var chckVal = chckbox.value;
var emailList = $("#TellfriendReceiver").val();

	if(chckbox.checked == true){
		if(emailList == ''){
			$("#TellfriendReceiver").val(chckVal);
		} else {
			$("#TellfriendReceiver").val(emailList + "," +chckVal);
		}
	} else if(chckbox.checked == false) {

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
