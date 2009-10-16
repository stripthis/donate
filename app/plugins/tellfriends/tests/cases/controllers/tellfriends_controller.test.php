
<?php 
/* TellfriendsController Test cases generated on: 2009-10-13 17:07:41*/
App::import('Controller', 'Tellfriends.Tellfriends');
App::import('Component', 'Tellfriends.Caplimit');
App::import('Component', 'Tellfriends.Recaptcha');

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
	 function testreferGetRenderedHtml() { 
     $result = $this->testAction('/tellfriends/tellfriends/refer', array('return' => 'render')); 
	  debug(htmlentities($result)); 
   }
/**
 * undocumented function
 *
 * @return void
 * @access public
 */	
	 function testreferGetViewVars() { 
      $result = $this->testAction('/tellfriends/tellfriends/refer', array('return' => 'vars')); 
	  debug($result); 
   }  
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testTellfriendscontactList() {
	 //$result = $this->Sut->contactList('your login email', base64_encode('login password'), 'email provider');
	}
}
?>