<?php 
/* SVN FILE: $Id$ */
/* UsersController Test cases generated on: 2009-04-19 10:04:43 : 1240131223*/
App::import('Controller', 'Users');

class TestUsers extends UsersController {
	var $autoRender = false;
}

class UsersControllerTest extends CakeTestCase {
	var $Users = null;

	function setUp() {
		$this->Users = new TestUsers();
		$this->Users->constructClasses();
	}

	function testUsersControllerInstance() {
		$this->assertTrue(is_a($this->Users, 'UsersController'));
	}

	function tearDown() {
		unset($this->Users);
	}
}
?>