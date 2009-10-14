<?php 
App::import('Model', 'tellfriends.tellfriend');

class TellfriendTestCase extends CakeTestCase {

    // Plugin fixtures located in /app/plugins/tellfriends/tests/fixtures/
    var $fixtures = array('plugin.tellfriends.tellfriend');
    var $tellfriendTest;
	
	function setUp() {
		$this->Sut = ClassRegistry::init('Tellfriend');
	}
    
    function testgetEmailsSentFromInTime() {
        echo $result =$this->Sut->getEmailsSentFromInTime('dhapola.shilpa@gmail.com');

    }
}
?>