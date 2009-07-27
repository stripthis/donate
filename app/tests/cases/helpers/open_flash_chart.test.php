<?php
class OpenFlachChartTestCase extends CakeTestCase {
	function setUp() {
		App::import('Helper', 'OpenFlashChart');
		$this->sut = new OpenFlashChartHelper();
	}

	function testYSteps() {
		// todo
		$result = $this->sut->ySteps(1, 10);
		$expected = array(1);
		$this->assertEqual($result, $expected);

		$result = $this->sut->ySteps(2, 10);
		$expected = array(1, 2);
		$this->assertEqual($result, $expected);

		$result = $this->sut->ySteps(3, 10);
		$expected = array(1, 2, 3);
		$this->assertEqual($result, $expected);

		$result = $this->sut->ySteps(100, 0);
		$expected = array();
		$this->assertEqual($result, $expected);
		
		$result = $this->sut->ySteps(20, 10);
		$this->assertEqual($result, range(2, 20, 2));
		
		$result = $this->sut->ySteps(28, 10);
		$this->assertEqual($result, range(4, 28, 4));
		
		$result = $this->sut->ySteps(32, 10);
		$this->assertEqual($result, range(5, 35, 5));
		
		$result = $this->sut->ySteps(35, 7);
		$this->assertEqual($result, range(5, 35, 5));

		$result = $this->sut->ySteps(36, 7);
		$this->assertEqual($result, range(5, 40, 5));

		$result = $this->sut->ySteps(35, 8);
		$this->assertEqual($result, range(5, 35, 5));
		
		$result = $this->sut->ySteps(35, 5);
		$this->assertEqual($result, range(10, 40, 10));
		
		$result = $this->sut->ySteps(35, 12);
		$this->assertEqual($result, range(5, 35, 5));
		
		$result = $this->sut->ySteps(35, 15);
		$this->assertEqual($result, range(4, 36, 4));
		
		$result = $this->sut->ySteps(60761, 10);
		$this->assertEqual($result, range(6080, 60800, 6080));
		
		$result = $this->sut->ySteps(48, 10);
		$this->assertEqual($result, range(5, 50, 5));
		
		$result = $this->sut->ySteps(720, 20);
		$this->assertEqual($result, range(40, 720, 40));

		$result = $this->sut->ySteps(913, 10);
		$this->assertEqual($result, range(100, 1000, 100));

		$result = $this->sut->ySteps(1081, 10);
		$this->assertEqual($result, range(110, 1100, 110));
		
		$result = $this->sut->ySteps(100, 10);
		$this->assertEqual($result, range(10, 100, 10));

		$result = $this->sut->ySteps(200, 10);
		$this->assertEqual($result, range(20, 200, 20));
		
		$result = $this->sut->ySteps(100, 9);
		$this->assertEqual($result, range(10, 100, 10));

		$result = $this->sut->ySteps(19000, 10);
		$this->assertEqual($result, range(1900, 19000, 1900));

		$result = $this->sut->ySteps(1000, 10);
		$this->assertEqual($result, range(100, 1000, 100));

		$result = $this->sut->ySteps(10000, 10);
		$this->assertEqual($result, range(1000, 10000, 1000));
	}
}
?>