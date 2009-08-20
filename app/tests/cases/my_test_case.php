<?php
define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
class MyTestCase extends CakeTestcase {
/**
 * undocumented function
 *
 * @param string $method 
 * @return void
 * @access public
 */
	function fakeRequest($method = 'post') {
		$_SERVER['REQUEST_METHOD'] = strtoupper($method);
	}
/**
 * undocumented function
 *
 * @param string $a 
 * @param string $b 
 * @param string $msg 
 * @return void
 * @access public
 */
	function is($a, $b, $msg = '') {
		return $this->assertIdentical($a, $b, $msg);
	}
/**
 * undocumented function
 *
 * @param string $a 
 * @param string $b 
 * @param string $msg 
 * @return void
 * @access public
 */
	function eq($a, $b, $msg = '') {
		return $this->assertEqual($a, $b, $msg);
	}
/**
 * undocumented function
 *
 * @param string $a 
 * @param string $b 
 * @param string $msg 
 * @return void
 * @access public
 */
	function false($a, $msg = '') {
		return $this->assertFalse($a, $msg);
	}
/**
 * undocumented function
 *
 * @param string $a 
 * @param string $b 
 * @param string $msg 
 * @return void
 * @access public
 */
	function true($a, $msg = '') {
		return $this->assertTrue($a, $msg);
	}
}
?>