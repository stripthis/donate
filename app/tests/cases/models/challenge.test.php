<?php 
/* SVN FILE: $Id$ */
/* Challenge Test cases generated on: 2009-04-08 14:04:25 : 1239194545*/
App::import('Model', 'Challenge');

class ChallengeTestCase extends CakeTestCase {
	var $Challenge = null;
	var $fixtures = array('app.challenge');

	function startTest() {
		$this->Challenge =& ClassRegistry::init('Challenge');
	}

	function testChallengeInstance() {
		$this->assertTrue(is_a($this->Challenge, 'Challenge'));
	}

	function testChallengeFind() {
		$this->Challenge->recursive = -1;
		$results = $this->Challenge->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Challenge' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-04-08 14:42:25',
			'modified'  => '2009-04-08 14:42:25'
		));
		$this->assertEqual($results, $expected);
	}
}
?>