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
	function _fakeRequest($method = 'post') {
		$_SERVER['REQUEST_METHOD'] = strtoupper($method);
	}
}
?>