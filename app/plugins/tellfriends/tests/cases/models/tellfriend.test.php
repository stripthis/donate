<?php 
App::import('Model', 'tellfriends.tellfriend');

class TellfriendCase extends CakeTestCase {

    // Plugin fixtures located in /app/plugins/tellfriends/tests/fixtures/
 //   var $fixtures = array('plugin.tellfriends.tellfriend');
	var $dropTables = false;
	
	function setUp() {
		$this->Sut = ClassRegistry::init('Tellfriend');
	}
/**
 * Check whether user is spamming -emails sent from sampe ip
 *
 * @param string $currentIP 
 * @return boolean 
 */	
	function testisIpSpamming() {
     	  $result =$this->Sut->isIpSpamming('127.0.0.1');
		  $this->assertTrue($result);

    }
/**
 *  Check emails sent from a particular address in given time exceeds the given limit
 *
 * @param string $email_address 
 * @return boolean 
 */	
    function testgetEmailsSentFromInTime() {
     	  $result =$this->Sut->getEmailsSentFromInTime('dhapola.shilpa@gmail.com');
		  $this->assertTrue($result);

    }
/**
 * Insert records in tellfriend and invited_friends tables
 *
 * @param  array $data, $email 
 * @return boolean
 */
 	 function testsaveReference() {
		$data = array();
		$data['Tellfriend']= array( 'receiver' => 's.dhapola85@yahoo.co.in shilpa.dhapola@gmail.com', 'sender' => 'shilpa.dhapola@enova-tech.net' ,'content' => 'Hi, Your friend wants you to check out this website: www.greenpeace.org','ip' => '127.0.0.1');
		$emails = array ('s.dhapola85@yahoo.co.in');
     	//$result =$this->Sut->saveReference($data, $emails);
		//$this->assertTrue($result);

    }  
}
?>