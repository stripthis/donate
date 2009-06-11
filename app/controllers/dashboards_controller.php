<?php
class DashboardsController extends AppController {
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $uses = array(
		'User'
	);
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {

	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_recalc_cache($type = null, $offset = 0) {
		$limit = 300;
		$this->set(compact('type', 'offset', 'limit'));
		if (empty($type)) {
			return;
		}

		ini_set('max_execution_time', 1800);
		ini_set('memory_limit', '1024M');

		if ($type == 'clear_file') {
			Cache::clear();
			clearCache();
			$this->Message->add('The cache has been cleared.', 'ok');
		}
		if ($type == 'session_restore') {
			User::restore();
		}

		if ($done) {
			$this->Message->add('The counter caches have been rebuilt.', 'ok');
		}
		$this->set(compact('done'));
	}
}
?>