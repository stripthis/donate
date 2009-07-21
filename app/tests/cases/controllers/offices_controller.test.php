<?php 
/* SVN FILE: $Id$ */
/* OfficesController Test cases generated on: 2009-07-21 17:07:02 : 1248189662*/
App::import('Controller', 'Offices');

class TestOffices extends OfficesController {
	var $autoRender = false;
}

class OfficesControllerTest extends CakeTestCase {
	var $Offices = null;

	function setUp() {
		$this->sut = ClassRegistry::init(Offices);
	}

	function tearDown() {
		unset($this->sut);
	}
}
?>