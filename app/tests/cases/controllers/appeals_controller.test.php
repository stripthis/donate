<?php 
/* SVN FILE: $Id$ */
/* AppealsController Test cases generated on: 2009-07-21 17:07:07 : 1248188527*/
App::import('Controller', 'Appeals');

class TestAppeals extends AppealsController {
	var $autoRender = false;
}

class AppealsControllerTest extends CakeTestCase {
	var $Appeals = null;

	function setUp() {
		$this->sut = ClassRegistry::init(Appeals);
	}

	function tearDown() {
		unset($this->sut);
	}
}
?>