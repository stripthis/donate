<?php 
/* SVN FILE: $Id$ */
/* Criterion Test cases generated on: 2009-04-10 10:04:04 : 1239353404*/
App::import('Model', 'Criterion');

class CriterionTestCase extends CakeTestCase {
	var $Criterion = null;
	var $fixtures = array('app.criterion');

	function startTest() {
		$this->Criterion =& ClassRegistry::init('Criterion');
	}

	function testCriterionInstance() {
		$this->assertTrue(is_a($this->Criterion, 'Criterion'));
	}

	function testCriterionFind() {
		$this->Criterion->recursive = -1;
		$results = $this->Criterion->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Criterion' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'points'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-04-10 10:50:04',
			'modified'  => '2009-04-10 10:50:04'
		));
		$this->assertEqual($results, $expected);
	}
}
?>