
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
 * Displays the refer view
 *
 * @return void
 * @access public
 */	
	 function testGetRenderedHtmlView() { 
     $result = $this->testAction('/tellfriends/tellfriends/refer', array('return' => 'render')); 
	 debug($result); 
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
 * Check if Comment content is spam
 *
 * @return void
 * @access public
 */	
	 function testAkismetCommentContentAppearsToBeSpam() { 
	 $comment = array('comment_author' => '',
                         'comment_author_email' => 'dhapola.shilpa@gmail.com', 
                         'comment_content' => 'Lose Weight',  
						 'comment_type'  => 'tell a friend'
						 );
	  $result = $this->Sut->Akismet->checkComment($comment);
	  $this->assertEqual('true', $result);
   } 
/**
 * Check if Author Email is spam
 *
 * @return void
 * @access public
 */	
	 function testAkismetAuthorEmailAppearsToBeSpam() { 
	 $comment = array('comment_author' => '',
                         'comment_author_email' => 'abc@xyz.com',   
                         'comment_content' => 'Hi, Your friend wants you to check out this websit...', 
						 'comment_type'  => 'tell a friend'
						 );
	  $result = $this->Sut->Akismet->checkComment($comment);
	  $this->assertEqual('true', $result);
   } 

/**
 * Get contact list with checkboxes from email provider e.g. gmail, yahoo
 *
 * @return void
 * @access public
 */
	function testGetContactListFromEmailProvider() {
	// $result = $this->Sut->contactList('your login email', base64_encode('login password'), 'email provider');
	}
}
?>