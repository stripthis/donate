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
	var $name= 'Caplimit'; 
	var $tellFriend;
	
	
	function initialize(&$controller) {
			// saving the controller reference for later use
			$this->controller =& $controller;
			App::import('Model','TellFriend');
		    $this->tellFriend = new TellFriend();
	}
	
	function checkCaps($emails) {
		if($this->checkForIpSpam() == false) {
		  Configure::write('App.tellafriendError','Sorry. You have been banned from sending more emails. Please try after sometime.');
		  return false;
     	}
		if($this->checkForSpamEmail($emails) != 'passed') {
		  $faultyEmail = $this->checkForSpamEmail($emails);
		  Configure::write('App.tellafriendError','Sorry. The email '.$faultyEmail.' has already been used many times. Please send again to another email.');
		  return false;
		}
		 
		   
		return true;   
		//pr($emails);
	}
	
	
	function checkForSpamEmail($emails) {
	  $toCheck = $this->tellFriend->getEmailsSentInTime();
	  foreach($emails as $email) {
	    foreach($toCheck as $emailToCheck => $counts) {
		  if($email == $emailToCheck) {
		    if($counts > Configure::read('App.emailsPerDay') ) {
			  return $emailToCheck;
			}
		  }
		}
	  }
	  return 'passed';
	
	}
	
	function checkForIpSpam() {
	 $currentIP = $this->getIP();
	 $isIpValid = $this->tellFriend->isIpSpamming($currentIP);
		 if($isIpValid != 0) {
		   return false;	 
		 } 
		 else
	       return true;	 
	}
	
	
	function getIP() {
	 return RequestHandlerComponent::getClientIP();	
	}
	
	
	
	
	function getTimeDifference( $start, $end )
	{
		$uts['start']      =    strtotime( $start );
		$uts['end']        =    strtotime( $end );
		if( $uts['start']!==-1 && $uts['end']!==-1 )
		{
			if( $uts['end'] >= $uts['start'] )
			{
				$diff    =    $uts['end'] - $uts['start'];
				if( $days=intval((floor($diff/86400))) )
					$diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )
					$diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )
					$diff = $diff % 60;
				$diff    =    intval( $diff );            
				return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
			}
			else
			{
				trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
			}
		}
		else
		{
			trigger_error( "Invalid date/time data detected", E_USER_WARNING );
		}
		return( false );
	}
	
	
	
	
	
	
	
	
}
