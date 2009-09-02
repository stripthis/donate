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
			'conditions' => array(
				'Tellfriend.ip' => $currentIP,
				'Tellfriend.time_sent BETWEEN ? AND ?' => array($timeBefore, $currentTime)
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
			'fields' => array('InvitedFriend.email')
		));

		$emails = Set::extract('/InvitedFriend/email', $emails);
		return array_count_values($emails);
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
				'time_sent' => date('Y-m-d H:i:s')
			);
			$inviteFriend->create($invitedFriendsEmails);
			if (!$inviteFriend->save()) {
				return false;
			}
		}
		return true;	 
	}
}
?>