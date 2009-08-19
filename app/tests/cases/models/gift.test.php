<?php
class GiftTest extends CakeTestCase {
	// var $fixtures = array('app.snippet');
	var $dropTables = false;

	function setUp() {
		$this->sut = ClassRegistry::init('Gift');
	}
}
?>