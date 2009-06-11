<?php 
/* SVN FILE: $Id$ */
/* Leader Test cases generated on: 2009-04-08 12:04:03 : 1239185043*/
App::import('Model', 'Leader');

class LeaderTestCase extends CakeTestCase {
	var $Leader = null;
	var $fixtures = array('app.leader');

	function startTest() {
		$this->Leader =& ClassRegistry::init('Leader');
	}

	function testLeaderInstance() {
		$this->assertTrue(is_a($this->Leader, 'Leader'));
	}

	function testLeaderFind() {
		$this->Leader->recursive = -1;
		$results = $this->Leader->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Leader' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'company'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-04-08 12:04:03',
			'modified'  => '2009-04-08 12:04:03'
		));
		$this->assertEqual($results, $expected);
	}
}
?>