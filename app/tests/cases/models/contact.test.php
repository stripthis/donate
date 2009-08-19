<?php
class ContactTest extends CakeTestCase {
	// var $fixtures = array('app.snippet');
	var $dropTables = false;

	function setUp() {
		$this->sut = ClassRegistry::init('Contact');
	}

	function testNameValidation() {
		$field = 'fname';
		$dontPass = array(
			't---', '#@@33434', '/sdasd2323/', '23', '2', '', '*&^', 'tim Kosch&^%',
			't,', 'Remy#Bertot'
		);
		foreach ($dontPass as $data) {
			$this->sut->data = array();
			$this->sut->validationErrors = array();
			$this->sut->set(array($field => $data));
			$this->sut->validates();
			$this->assertTrue(array_key_exists($field, $this->sut->validationErrors), $data);
		}

		$pass = array(
			'tim', 'Karl-Heinz', 'Remy, Bertot', 'Karl- Heinz'
		);
		foreach ($pass as $data) {
			$this->sut->data = array();
			$this->sut->validationErrors = array();
			$this->sut->set(array($field => $data));
			$this->sut->validates();
			$this->assertFalse(array_key_exists($field, $this->sut->validationErrors), $data);
		}


		$field = 'lname';
		$dontPass = array(
			'Kosch#tzki', '/asd2323/', '23', '2', '', '*&^', 'tim Kosch&^%',
			't,', 'Remy#Bertot', 'Remy,  Bertot'
		);
		foreach ($dontPass as $data) {
			$this->sut->data = array();
			$this->sut->validationErrors = array();
			$this->sut->set(array($field => $data));
			$this->sut->validates();
			$this->assertTrue(array_key_exists($field, $this->sut->validationErrors), $data);
		}

		$pass = array(
			'Bertot', 'Koschützki', 'geisendörfer', 'Kosch tzki', 'Kosch,tzki'
		);
		foreach ($pass as $data) {
			$this->sut->data = array();
			$this->sut->validationErrors = array();
			$this->sut->set(array($field => $data));
			$this->sut->validates();
			$this->assertFalse(array_key_exists($field, $this->sut->validationErrors), $data);
		}
	}
}
?>