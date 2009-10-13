
<?php 
/* TellfriendsController Test cases generated on: 2009-10-13 17:07:41*/
App::import('Controller', 'Tellfriends.Tellfriends');

class TestTellfriends extends TellfriendsController {
	var $autoRender = false;
}

class TellfriendsControllerTest extends CakeTestCase {
	var $Tellfriends = null;

	function setUp() {
		$this->sut = ClassRegistry::init('Tellfriends');
	}

	function tearDown() {
		unset($this->sut);
	}
}
?>