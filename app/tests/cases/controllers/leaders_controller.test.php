<?php 
/* SVN FILE: $Id$ */
/* LeadersController Test cases generated on: 2009-04-08 12:04:14 : 1239185114*/
App::import('Controller', 'Leaders');

class TestLeaders extends LeadersController {
	var $autoRender = false;
}

class LeadersControllerTest extends CakeTestCase {
	var $Leaders = null;

	function setUp() {
		$this->Leaders = new TestLeaders();
		$this->Leaders->constructClasses();
	}

	function testLeadersControllerInstance() {
		$this->assertTrue(is_a($this->Leaders, 'LeadersController'));
	}

	function tearDown() {
		unset($this->Leaders);
	}
}
?>