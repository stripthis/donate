<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2009-04-19 10:04:01 : 1240130701*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'login'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'active'  => 1,
			'created'  => '2009-04-19 10:45:01',
			'modified'  => '2009-04-19 10:45:01'
		));
		$this->assertEqual($results, $expected);
	}
}
?>