<?php
class Tellfriend extends AppModel {
	var $name = 'Tellfriend';
	var $validate = array(
		'receiver' =>  array(
			VALID_NOT_EMPTY,
			'email' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter atleast one email address that is correct'
			)
		),
	);

	var $actsAs = array('Akismet' => array(
		'content' => 'content',
		'type' => false,
		'owner' => 'receiver',
		'is_spam' => 'spam'
	));

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
		$timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.ipBanTime')));
		$currentTime = date('Y-m-d H:i:s');
		$noOfEmails = $this->find('count', array(
			'contain' => false,
			'conditions' => array(
				'TellFriend.ip' => $currentIP,
				'TellFriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
			)
		));
		return $noOfEmails > Configure::read('App.maxEmailsSentFromIp');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function getEmailsSentInTime() {
		$emailArray = array();
		$timeBefore = date('Y-m-d H:i:s', (time() - Configure::read('App.spamEmailTimeLimit')));
		$currentTime = date('Y-m-d H:i:s');
		$emails = $this->InvitedFriend->find('all', array(
			'conditions' => array(
				'InvitedFriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
			),
			'fields' => array('InvitedFriend.email'),
			'contain' => false
		));

		$emails = Set::extract('/InvitedFriend/email', $emails);
		return array_count_values($emailArray);
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
		$invitedFriendsEmails = array();
		foreach ($emails as $key => $val) {
			$invitedFriendsEmails['InvitedFriend']['email'] = $val;
			$invitedFriendsEmails['InvitedFriend']['tellfriend_id'] = $this->id;
			$inviteFriend->create();
			if (!$inviteFriend->save($invitedFriendsEmails)) {
				return false;
			}
		}
		return true;	 
	}
}
?>