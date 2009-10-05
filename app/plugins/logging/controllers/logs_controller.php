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
		Assert::true(User::allowed($this->name, $this->action), '403');

		$this->paginate['Log'] = array(
			'contain' => array('User', 'Gift'),
			'limit' => 10,
			'order' => array('Log.continous_id' => 'desc')
		);
		$logs = $this->paginate($this->Log);
		$this->set(compact('logs'));
	}
}
?>