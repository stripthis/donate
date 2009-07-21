<?php 
/* SVN FILE: $Id$ */
/* AppealsController Test cases generated on: 2009-07-21 16:07:34 : 1248188314*/
App::import('Controller', 'Appeals');

class TestAppeals extends AppealsController {
	var $autoRender = false;
}

class AppealsControllerTest extends CakeTestCase {
	var $Appeals = null;

	function setUp() {
		$this->Appeals = new TestAppeals();
		$this->Appeals->constructClasses();
	}

	function testAppealsControllerInstance() {
		$this->assertTrue(is_a($this->Appeals, 'AppealsController'));
	}

	function tearDown() {
		unset($this->Appeals);
	}
}
?>