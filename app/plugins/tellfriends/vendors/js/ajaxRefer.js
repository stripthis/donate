$(document).ready(function() {
    $("input:checkbox").click(function() { 
			var chckVal = $(this).val();
			//appending email address of checked checkbox
			if($(this).is(':checked') == true){
				addContacts(chckVal);
			} else if($(this).is(':checked') == false) { //removing email address of unchecked checkbox
				removeContacts(chckVal);
			}
	});
   
   $("span.spantxt").click(function() { 
			arr = Array();
			arr = $(this).attr('id').split("_");
			var checkboxId = 'contactcheckbox_'+arr[1];
			var chckVal = $('#'+checkboxId).val();
			//appending email address of checked checkbox
			
		if($('#'+checkboxId).is(':checked') == false){
				$('#'+checkboxId).attr('checked', true);
				addContacts(chckVal);
			} else if($('#'+checkboxId).is(':checked') == true) { //removing email address of unchecked checkbox
			    $('#'+checkboxId).attr('checked', false);
				removeContacts(chckVal);
			}
	});
    $("input#confirm").click(function() { 
							parent.tb_remove();
							var prevEmailList = parent.$("#TellfriendReceiver").val();
							if(prevEmailList == ''){
								var newEmailList  = $("#openinviter_contact_list").val();
							} else {
								var newEmailList  = prevEmailList + "," + $("#openinviter_contact_list").val();
							}
							parent.$("#TellfriendReceiver").val(newEmailList);
							parent.$("#TellfriendSender").val($("#your_login_email").val());
									 });
});
function addContacts(chckVal){
	     var emailList = $("#openinviter_contact_list").val();
         if(emailList == ''){
					$("#openinviter_contact_list").val(chckVal);
				} else {
					$("#openinviter_contact_list").val(emailList + "," +chckVal);
				}	
	
}
function removeContacts(chckVal){
				var emailList = $("#openinviter_contact_list").val();
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

			 
                    

