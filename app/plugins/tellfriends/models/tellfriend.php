<?php
class Tellfriend extends TellfriendsAppModel {
	var $validate = array(
		'receiver' =>  array(
			VALID_NOT_EMPTY,
			'email' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter at least one email address that is correct'
			)
		),
	);

	var $hasMany = array('InvitedFriend');

	var $cacheQueries = false;
/**
 * undocumented function
 *
 * @param string $currentIP 
 * @return void
 * @access public
 */
	function isIpSpamming($currentIP) {
		$timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.tellafriend.ipBanTime')));
		$currentTime = date('Y-m-d H:i:s');
		$noOfEmails = $this->find('count', array(
			'conditions' => array(
				'Tellfriend.ip' => $currentIP,
				'Tellfriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
			)
		));

		return $noOfEmails > Configure::read('App.tellafriend.maxEmailsSentFromIp');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function getEmailsSentInTime() {
		$emailArray = array();
		$timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.tellafriend.spamEmailTimeLimit')));
		$currentTime = date('Y-m-d H:i:s');
		$emails = $this->InvitedFriend->find('all', array(
			'conditions' => array(
				'InvitedFriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
			),
			'fields' => array('InvitedFriend.email')
		));

		$emails = Set::extract('/InvitedFriend/email', $emails);
		return array_count_values($emails);
	}
/**
 * Get No of email sent from any email in a day
 *
 * @return boolean true or false
 * @access public
 */
	function getEmailsSentFromInTime($email) {
	
	$timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.tellafriend.ipBanTime')));
		$currentTime = date('Y-m-d H:i:s');
		$noOfSentEmails= $this->InvitedFriend->find('count', array(
			'conditions' => array(
				'InvitedFriend.sender_email' => $email,
				'InvitedFriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
			)
		));

		return $noOfSentEmails > Configure::read('App.tellafriend.maxEmailsSentFromEmail');
	}
/**
 * undocumented function
 *
 * @param string $data 
 * @param string $emails 
 * @return void
 * @access public
 */
	function saveReference($data, $emails) {
		$inviteFriend = ClassRegistry::init('InvitedFriend');

		$this->save($data);

		foreach ($emails as $key => $val) {
			$invitedFriendsEmails = array(
				'email' => $val,
				'tellfriend_id' => $this->id,
				'sender_email' => $data['Tellfriend']['sender']

		);
			$inviteFriend->create(false);
			if (!$inviteFriend->save($invitedFriendsEmails)) {
				return false;
			}
		}
		return true;
	}
}
?>