<?php
/**
 * Manage Tell a Friend
 * 
 * @package 	tellafriend
 * @author 		Mayank Bhramar <mayank.bhramar@enova-tech.net>
 * @copyright 	Enova
 */
class TellfriendsController extends AppController {


  var $uses = array('Tellfriend');
  var $components = array('Caplimit');
  
  function refer() {
     $allowedCharInEmail = array('@',',','.','-','_');
	 App::import('Sanitize');
	 
     if(!empty($this->data)) {
    	 $this->data['Tellfriend']['receiver'] = Sanitize::paranoid($this->data['Tellfriend']['receiver'],$allowedCharInEmail);
		 $toEmail = explode(',', $this->data['Tellfriend']['receiver']);
		 $saveData = $this->data;
		 $saveData['Tellfriend']['ip'] = $this->Caplimit->getIP();
		 
		 /**
		  * Check for Cap Limits on the user.
		  * @param none
		  * @return none
		  **/
		  if($this->Caplimit->checkCaps($toEmail) == false)  {
		     $this->render('refer_not_allowed');			 
			 } else {
	  // Save data for tellfriend. 
	   if($this->Tellfriend->saveReference($saveData, $toEmail)) {
	   
			foreach($toEmail as $email) {
			 $emailSettings = array(
				'vars' => array(
				                'mail_message' => $this->data['Tellfriend']['content']								
								),
				'mail' => array(
					'to' => $email
					, 'subject' => 'Friend suggested you ' . Configure::read('App.name')
					, 'delivery' => 'debug'
				)
			);
			 if(Mailer::deliver('tellfriend', $emailSettings)) {
			  $this->Tellfriend->saveField('sent',1);
			  $this->Message->add(__('Your message has been sent to your friends.', true), 'ok', true, $this->referer());
			  }
			  else {
			  $this->Message->add(__('Your message was not sent due to an internal problem. Please try again.', true), 'ok', true, $this->referer());
			  }
			}
			
		 }
		}   // cap limit end
	 }
  }	 
  
}
?>
