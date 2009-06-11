<?php 
/* SVN FILE: $Id$ */
/* Criteria Test cases generated on: 2009-04-10 10:04:06 : 1239352806*/
App::import('Model', 'Criteria');

class CriteriaTestCase extends CakeTestCase {
	var $Criteria = null;
	var $fixtures = array('app.criteria');

	function startTest() {
		$this->Criteria =& ClassRegistry::init('Criteria');
	}

	function testCriteriaInstance() {
		$this->assertTrue(is_a($this->Criteria, 'Criteria'));
	}

	function testCriteriaFind() {
		$this->Criteria->recursive = -1;
		$results = $this->Criteria->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Criteria' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'points'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-04-10 10:40:05',
			'modified'  => '2009-04-10 10:40:05'
		));
		$this->assertEqual($results, $expected);
	}
}
?>