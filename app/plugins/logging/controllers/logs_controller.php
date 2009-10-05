<?php
class LogsController extends LoggingAppController {
	var $helpers = array('MyLog');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Log'] = array(
			'contain' => array('User', 'Gift'),
			'limit' => 10,
			'order' => array('Log.created' => 'desc'),
		);
		$logs = $this->paginate($this->Log);
		$this->set(compact('logs'));
	}
}
?>