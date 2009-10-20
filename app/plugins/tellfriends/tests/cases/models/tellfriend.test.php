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
 * Test given ip is spamming.Test passes if it is spamming.
 *
 * @return void
 */	
	function testGivenIpIsSpamming() {
     	  $result =$this->Sut->isIpSpamming('127.0.0.1');
		  $this->assertTrue($result);

    }
/**
 * Test given ip is not spamming.Test passes if it is not spamming. 
 *
 * @return void
 */	
	function testGivenIpIsNotSpamming() {
     	  $result =$this->Sut->isIpSpamming('127.0.0.1');
		  $this->assertFalse($result);

    }
/**
 * Check emails sent from a given email address in given time exceeds the given limit.Test passes if it exceeds given limit.
 *
 * @return void
 */	
    function testEmailsSentFromGivenEmailIdExceedsLimit() {
     	  $result =$this->Sut->getEmailsSentFromInTime('dhapola.shilpa@gmail.com');
		  $this->assertTrue($result);

    }
/**
 * Test emails sent from a given email address in given time does not exceed the given limit.Test passes if it does not exceed given limit. 
 *
 * @return void
 */	
    function testEmailsSentFromGivenEmailIdNotExceedsLimit() {
     	  $result =$this->Sut->getEmailsSentFromInTime('dhapola.shilpa@gmail.com');
		  $this->assertFalse($result);

    }
/**
 * Insert records in tellfriend and invited_friends tables
 *
 * @return void
 */
 	 function testsaveReference() {
		$data = array();
		$data['Tellfriend']= array( 'receiver' => 's.dhapola85@yahoo.co.in', 'sender' => 'shilpa.dhapola@enova-tech.net' ,'content' => 'Hi, Your friend wants you to check out this website: www.greenpeace.org','ip' => '127.0.0.1');
		$emails = array ('s.dhapola85@yahoo.co.in');
     	//$result =$this->Sut->saveReference($data, $emails);
		//$this->assertTrue($result);

    }  
}
?>