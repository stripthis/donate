<?php
class BugsAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		include('bugs_config.php');
		Configure::write($config);
	}
}
?>
