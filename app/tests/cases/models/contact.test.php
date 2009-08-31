<?php
require_once(dirname(dirname(__FILE__)) . DS . 'my_test_case.php');
class ContactTest extends MyTestCase {
	// var $fixtures = array('app.snippet');
	var $dropTables = false;

	function setUp() {
		$this->Sut = ClassRegistry::init('Contact');
	}

	function testNameValidation() {
		$field = 'fname';
		$dontPass = array(
			't---', '#@@33434', '/sdasd2323/', '23', '2', '*&^', 'tim Kosch&^%',
			't,', 'Remy#Bertot'
		);
		foreach ($dontPass as $data) {
			$this->Sut->data = array();
			$this->Sut->validationErrors = array();
			$this->Sut->set(array($field => $data));
			$this->Sut->validates();
			$this->true(array_key_exists($field, $this->Sut->validationErrors), $data);
		}

		$pass = array(
			'tim', 'Karl-Heinz', 'Remy, Bertot', 'Karl- Heinz'
		);
		foreach ($pass as $data) {
			$this->Sut->data = array();
			$this->Sut->validationErrors = array();
			$this->Sut->set(array($field => $data));
			$this->Sut->validates();
			$this->false(array_key_exists($field, $this->Sut->validationErrors), $data);
		}


		$field = 'lname';
		$dontPass = array(
			'Kosch#tzki', '/asd2323/', '23', '2', '', '*&^', 'tim Kosch&^%',
			't,', 'Remy#Bertot', 'Remy,  Bertot'
		);
		foreach ($dontPass as $data) {
			$this->Sut->data = array();
			$this->Sut->validationErrors = array();
			$this->Sut->set(array($field => $data));
			$this->Sut->validates();
			$this->true(array_key_exists($field, $this->Sut->validationErrors), $data);
		}

		$pass = array(
			'Bertot', 'Koschützki', 'geisendörfer', 'Kosch tzki', 'Kosch,tzki'
		);
		foreach ($pass as $data) {
			$this->Sut->data = array();
			$this->Sut->validationErrors = array();
			$this->Sut->set(array($field => $data));
			$this->Sut->validates();
			$this->false(array_key_exists($field, $this->Sut->validationErrors), $data);
		}
	}
}
?>