<?php 
App::import('Controller', 'Gifts');
require_once(dirname(dirname(__FILE__)) . DS . 'my_test_case.php');
class GiftsControllerTest extends MyTestCase {
	var $dropTables = false;
	var $sut = null;

	function setup() {
		$this->sut = new GiftsController();
		$this->sut->constructClasses();
		$this->sut->Component->initialize($this->sut);
		$this->sut->beforeFilter();
		$this->sut->Component->startup($this->sut);
	}

	function testAddPullsInAllOptions() {
		$vars = $this->testAction('/gifts/add', array('return' => 'vars'));
		$this->assertEqual(count($vars['countryOptions']), 275);
		$this->assertEqual(count($vars['appealOptions']), 1);
		$this->assertEqual(count($vars['officeOptions']), 1);
	}

	function testAddValidation() {
		$this->_fakeRequest('post');

		$this->sut->add();
		$this->assertEqual(count($this->sut->viewVars['flashMessages']), 1);
	}
}
?>