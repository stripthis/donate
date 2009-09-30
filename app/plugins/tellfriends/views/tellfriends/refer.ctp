<script type="text/javascript">
function GetXmlHttpObject()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {
  // code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlhttp;
}

function getContactList()
{
var xmlhttp = GetXmlHttpObject();
if(xmlhttp){
 var email =document.getElementById("openinviterEmailBox").value;
 var pass = document.getElementById("openinviterPasswordBox").value;
 var provider =document.getElementById("openinviterProviderBox").value;
 
var url="tellfriends/tellfriends/contactList/"+email+"/"+pass+"/"+provider;
xmlhttp.open("POST",url,true);
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4)
  {

  document.getElementById("contactList").innerHTML=xmlhttp.responseText;
  }
}
xmlhttp.send(null);
}
}
function tellFriends(chckbox)
{

	if(chckbox.checked == true){
		if(document.getElementById("TellfriendReceiver").value == ''){
			document.getElementById("TellfriendReceiver").value = chckbox.value;
		} else {
		document.getElementById("TellfriendReceiver").value = document.getElementById("TellfriendReceiver").value + "," +chckbox.value;
		}
	} else if(chckbox.checked == false) {
		var str = document.getElementById("TellfriendReceiver").value;
		var result = "";
		if(str.indexOf(chckbox.value) == 0){
			result = str.replace(chckbox.value, "");
		}else{
		     var replaceWith = ","+chckbox.value;
			result = str.replace(replaceWith, "");
		}
		if(result.charAt(0) == ","){
			result = result.replace(",", "");
		}
		document.getElementById("TellfriendReceiver").value = result;
	}

}
</script>
<div id="referDiv">

<?php
$providers =array(
  'aol'=>'AOL',
  'gmail'=>'Gmail',
   'yahoo'=>'Yahoo',
   'hotmail'=>'Hotmail'
 );
 echo $form->create('openinviter', array('url' =>array('controller'=>'tellfriends', 'action'=>'contactList')   )); ?>
<table align='center' class='thTable' cellspacing='0' cellpadding='0' style='border:none;'>
                                                <tr><td colspan='2' align='center'>OpenInviter</td></tr>
                                                <tr class='thTableRow'><td align='right'></td><td><?php  echo $form->input('email_box', array('type' => 'text','label' => __('Email',true),'class'=>'input text required')); //text
# echo $form->input('password'); ?></td></tr>
                                                <tr class='thTableRow'><td align='right'></td><td><?php  echo $form->input('password_box', array('type' => 'password','label' => __('Password',true),'class'=>'input text required')); ?></td></tr>
                                                <tr class='thTableRow'><td align='right'></td>
                                                <td>
                                                      <?php echo $form->input('provider_box', array('label' => __('Email provider',true),'options' => $providers)); ?>

</td></tr>
                                                        
                                                        <tr class='thTableImportantRow'><td colspan='2' align='center'><input type='button' name='import' value='Import Contacts' onclick="getContactList();"></td></tr>
                                                    </table> 
 <?php echo $form->end(); ?>
 

<?php echo $form->create('tellafriend', array('url' =>array('controller'=>'tellfriends', 'action'=>'refer')   )); ?>
<fieldset>
  <legend><?php sprintf(__('Tell A Friend', true)); ?></legend>
  <div id = "contactList">
 </div>
  <ul>
    <li>
      <?php echo $form->input('Tellfriend.receiver', array('type' => 'text','label' => __('Friends\' Email (comma separated emails)',true).' *','class'=>'input text required','div'=>false))?>

    </li>
        <li>
      <?php echo $form->input('Tellfriend.sender', array('type' => 'text','label' => __('Your Email',true).' (Optional)','class'=>'input text required','div'=>false))?>

    </li>

    <li>
      <?php echo $form->input('Tellfriend.content', array('type' => 'textarea','label' => __('Your Message',true),'class'=>'input text required','div'=>false, 'value' => __('Hi, Your friend wants you to check out this website: www.greenpeace.org ', true)))?>
    </li>
     <li>
      <?php $recaptcha->display_form('echo'); ?>
    </li>
    
    <li>
	 <?php echo $form->end('Send Email'); ?>
    </li>
  </ul>
</fieldset>
</div>