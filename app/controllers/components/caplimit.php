<?php
/**
 * Cap Limit Component for Tell a friend
 * A component for Cap Limit
 * 
 * Copyright (c)	GREENPEACE INTERNATIONAL 2009
 * 
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Greenpeace International
 * @license		 GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php
 * @author		 mayank.bhramar@enova-tech.net
 *
 */
class CaplimitComponent extends Object {
	var $name = 'Caplimit';
	var $TellFriend;
/**
 * undocumented function
 *
 * @param string $controller 
 * @return void
 * @access public
 */
	function initialize(&$controller) {
		$this->controller =& $controller;
		$this->TellFriend = ClassRegistry::init('TellFriend');
	}
/**
 * undocumented function
 *
 * @param string $emails 
 * @return void
 * @access public
 */
	function checkCaps($emails) {
		if ($this->checkForIpSpam() == false) {
			$msg = 'Sorry. You have been banned from sending more emails.';
			$msg .= ' Please try after sometime.';
			Configure::write('App.tellafriendError', $msg);
			return false;
		}

		if ($this->checkForSpamEmail($emails) != 'passed') {
			$faultyEmail = $this->checkForSpamEmail($emails);
			$msg = 'Sorry. The email ' . $faultyEmail . ' has already been used many times.';
			$msg .= ' Please send again to another email.';
			Configure::write('App.tellafriendError', $msg);
			return false;
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $emails 
 * @return void
 * @access public
 */
	function checkForSpamEmail($emails) {
		$toCheck = $this->TellFriend->getEmailsSentInTime();

		foreach ($emails as $email) {
			foreach ($toCheck as $emailToCheck => $counts) {
				if ($email == $emailToCheck) {
					if ($counts > Configure::read('App.emailsPerDay') ) {
						return $emailToCheck;
					}
				}
			}
		}
		return 'passed';
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function checkForIpSpam() {
		$ip = RequestHandlerComponent::getClientIP();
		return $this->TellFriend->isIpSpamming($ip) == 0;
	}
/**
 * undocumented function
 *
 * @param string $start 
 * @param string $end 
 * @return void
 * @access public
 */
	function getTimeDifference($start, $end) {
		$uts['start'] = strtotime( $start );
		$uts['end'] = strtotime( $end );

		if ($uts['start'] !== -1 && $uts['end'] !== -1) {
			if ($uts['end'] >= $uts['start']) {
				$diff = $uts['end'] - $uts['start'];

				if ($days= intval(floor($diff / 86400))) {
					$diff = $diff % 86400;
				}
				if ($hours = intval(floor($diff / 3600))) {
					$diff = $diff % 3600;
				}
				if ($minutes = intval(floor($diff / 60)) ) {
					$diff = $diff % 60;
				}

				$seconds = intval($diff);            
				return compact('days', 'hours', 'minutes', 'seconds');
			}
			trigger_error("Ending date/time is earlier than the start date/time", E_USER_WARNING);
		}
		trigger_error( "Invalid date/time data detected", E_USER_WARNING );
		return false;
	}
}
?>