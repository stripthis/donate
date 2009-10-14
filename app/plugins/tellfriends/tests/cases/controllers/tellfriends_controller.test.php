
<?php 
/* TellfriendsController Test cases generated on: 2009-10-13 17:07:41*/
App::import('Controller', 'Tellfriends.Tellfriends');

class TestTellfriends extends TellfriendsController {
	var $autoRender = false;
}

class TellfriendsControllerTest extends CakeTestCase {
	var $Tellfriends = null;

	function startTest() {
		$this->Sut = new TellfriendsController();
		$this->Sut->constructClasses();
		$this->Sut->Component->initialize($this->Sut);
		$this->Sut->beforeFilter();
		$this->Sut->Component->startup($this->Sut);

		$this->Tellfriend = ClassRegistry::init('Tellfriend');
		$this->InvitedFriend = ClassRegistry::init('InvitedFriend');


		$models = array('Tellfriend', 'InvitedFriend');
		AppModel::resetRequired($models);

	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function endTest() {
		$this->Sut->Session->del($this->Sut->Message->sessKey);
	}
	/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testcontactList() {
	 $result = $this->Sut->contactList('your login email', base64_encode('login password'), 'email provider');
     echo $result;
		}
}
?>