<?php 
/* SVN FILE: $Id$ */
/* CriteriaController Test cases generated on: 2009-04-19 11:04:54 : 1240131654*/
App::import('Controller', 'Criteria');

class TestCriteria extends CriteriaController {
	var $autoRender = false;
}

class CriteriaControllerTest extends CakeTestCase {
	var $Criteria = null;

	function setUp() {
		$this->Criteria = new TestCriteria();
		$this->Criteria->constructClasses();
	}

	function testCriteriaControllerInstance() {
		$this->assertTrue(is_a($this->Criteria, 'CriteriaController'));
	}

	function tearDown() {
		unset($this->Criteria);
	}
}
?>