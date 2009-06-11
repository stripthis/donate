<?php 
/* SVN FILE: $Id$ */
/* ChallengesController Test cases generated on: 2009-04-08 14:04:07 : 1239194587*/
App::import('Controller', 'Challenges');

class TestChallenges extends ChallengesController {
	var $autoRender = false;
}

class ChallengesControllerTest extends CakeTestCase {
	var $Challenges = null;

	function setUp() {
		$this->Challenges = new TestChallenges();
		$this->Challenges->constructClasses();
	}

	function testChallengesControllerInstance() {
		$this->assertTrue(is_a($this->Challenges, 'ChallengesController'));
	}

	function tearDown() {
		unset($this->Challenges);
	}
}
?>