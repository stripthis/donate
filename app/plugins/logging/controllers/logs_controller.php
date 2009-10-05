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

		$defaults = array(
			'model' => null,
			'user_id' => null,
			'my_limit' => 20,
			'custom_limit' => false,
			'start_date_day' => '01',
			'start_date_year' => date('Y'),
			'start_date_month' => '01',
			'end_date_day' => '31',
			'end_date_year' => date('Y'),
			'end_date_month' => '12'
		);
		$params = am($defaults, $this->params['url'], $this->params['named']);
		unset($params['ext']);
		unset($params['url']);

		if (is_numeric($params['custom_limit'])) {
			if ($params['custom_limit'] > 75) {
				$params['custom_limit'] = 75;
			}
			if ($params['custom_limit'] == 0) {
				$params['custom_limit'] = 50;
			}
			$params['my_limit'] = $params['custom_limit'];
		}

		$conditions = array();
		if (!empty($params['model'])) {
			$conditions['Log.model'] = $params['model'];
		}
		if (!empty($params['user_id'])) {
			$conditions['Log.user_id'] = $params['user_id'];
		}
		$conditions = $this->Log->dateRange($conditions, $params, 'created');
		$this->Session->write('logs_filter_conditions', $conditions);

		$userOptions = ClassRegistry::init('User')->find('list', array(
			'conditions' => array('User.office_id' => $this->Session->read('Office.id')),
		));

		$this->paginate['Log'] = array(
			'conditions' => $conditions,
			'contain' => array('User', 'Gift', 'Transaction'),
			'limit' => $params['my_limit'],
			'order' => array('Log.continous_id' => 'desc')
		);
		$logs = $this->paginate($this->Log);
		$this->set(compact('logs', 'params', 'userOptions'));
	}
}
?>