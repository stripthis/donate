<?php
class Tellfriend extends AppModel {
 var $name = 'Tellfriend';
 var $validate = array(
        'receiver' =>  array(VALID_NOT_EMPTY,
							 'email' =>array('rule' => 'notEmpty',
							 				  'message' => 'Please enter atleast one email address that is correct'
											)
										
										),
        'content' =>  array(
						array( 'rule' => array('notSpam'),
							   'message' => 'This comment appears to be spam. Please contact us if the problem persists.',
							   'required' => true
							  )	 
						) 
    );
	
 var $hasMany = array('InvitedFriend');
 var $cacheQueries = false;
	
	
	function isIpSpamming($currentIP) {
	
	 $timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.ipBanTime')));
	 $currentTime = date('Y-m-d H:i:s');
	 $params = array(
	 					'conditions' => array('Tellfriend.ip' => $currentIP,
											  'Tellfriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
											  )
							
	 				);
	 $noOfEmails = $this->find('count',$params);
	 //pr($noOfEmails);
	 //pr(	Configure::read('App.maxEmailsSentFromIp'));
	 if ($noOfEmails > Configure::read('App.maxEmailsSentFromIp') ) {
			return '1';
	 } else {
	 		return '0'; 
	 }
					
	}

   function getEmailsSentInTime() {
     $emailArray = array();
	 $timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.spamEmailTimeLimit')));
	 $currentTime = date('Y-m-d H:i:s');
	 $params = array(
	 					'conditions' => array(
											  'Tellfriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
											  ),
						'fields' => array('InvitedFriend.email')
							
	 				);
					
      $emails = $this->InvitedFriend->find('all',$params);
	  foreach($emails as $email) {
	   $emailArray[] = $email['InvitedFriend']['email'];
	  }
	  $countEmails = array_count_values($emailArray);
	  
	  return($countEmails);
   
   }
   
   function saveReference($data, $emails) {
     App::import('model', 'InvitedFriend');
	 $inviteFriend = new InvitedFriend();
     $this->save($data);
	 $invitedFriendsEmails = array();
		foreach($emails as $key=>$val) {
		   $invitedFriendsEmails['InvitedFriend']['email'] = $val;
		   $invitedFriendsEmails['InvitedFriend']['tellfriend_id'] = $this->id;
		   $inviteFriend->create();
		   if(!$inviteFriend->save($invitedFriendsEmails)) {
		    return false;
		   }
		 }
	 return true;	 
   
   }

}
?>