<?php 
/* SVN FILE: $Id$ */
/* CriteriasController Test cases generated on: 2009-04-10 10:04:18 : 1239352398*/
App::import('Controller', 'Criterias');

class TestCriterias extends CriteriasController {
	var $autoRender = false;
}

class CriteriasControllerTest extends CakeTestCase {
	var $Criterias = null;

	function setUp() {
		$this->Criterias = new TestCriterias();
		$this->Criterias->constructClasses();
	}

	function testCriteriasControllerInstance() {
		$this->assertTrue(is_a($this->Criterias, 'CriteriasController'));
	}

	function tearDown() {
		unset($this->Criterias);
	}
}
?>