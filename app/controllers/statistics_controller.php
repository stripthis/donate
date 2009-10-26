<?php
class StatisticsController extends AppController {
	var $helpers = array('OpenFlashChart');
	var $uses = array();
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Gift = ClassRegistry::init('Gift');
		$this->User = ClassRegistry::init('User');

		$this->_handleTimePeriod();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$gifts = $this->Gift->find('all', array(
			'conditions' => $this->_conditions(),
			'fields' => array('created', 'amount', 'archived', 'complete')
		));

		$months = Common::months($this->startDate, $this->endDate, false);
		$result = array();
		foreach ($months as $month) {
			$result[$month] = array();
			foreach ($gifts as $gift) {
				if (Common::sameMonth($gift['Gift']['created'], $month)) {
					$result[$month][] = $gift;
				}
			}
		}
		$this->set(compact('result', 'gifts', 'months'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_users() {
		$result = array();
		$users = $this->User->find('all', array(
			'fields' => array('first_name', 'last_name', 'id', 'created')
		));

		$months = Common::months($this->startDate, $this->endDate, false);
		$result = array();
		foreach ($months as $month) {
			$result[$month] = array();
			foreach ($users as $user) {
				if (Common::sameMonth($user['User']['created'], $month)) {
					$result[$month][] = $user;
				}
			}
		}
		$this->set(compact('result', 'users', 'months'));
	}
/**
 * Universal conditions for statistics for a given timeperiod
 *
 * @param string $field 
 * @param string $model 
 * @return void
 * @access public
 */
	function _conditions($field = 'created', $model = 'User') {
		// @todo: measure archived time
		return array(
			'office_id' => $this->Session->read('Office.id'),
			"DATE_FORMAT(" . $field. ", '%Y-%m-%d') >= '" . $this->startDate . "'",
			"DATE_FORMAT(" . $field . ", '%Y-%m-%d') <= '" . $this->endDate . "'",
		);
	}
/**
 * Calculate the whole business around the date range that was picked
 *
 * @return void
 * @access public
 */
	function _handleTimePeriod() {
		$sessKeyStart = 'stats_start_date';
		$sessKeyEnd = 'stats_end_date';

		if (!$this->isPost()) {
			$startDate = strtotime(Configure::read('Stats.startDate'));

			// last day of last month
			$endDate = strtotime('-1 day', strtotime(date('Y-m-01')));

			if ($this->Session->check($sessKeyStart)) {
				$startDate = $this->Session->read($sessKeyStart);
			}
			if ($this->Session->check($sessKeyEnd)) {
				$endDate = $this->Session->read($sessKeyEnd);
			}

			if (isset($this->params['url']['startDate'])) {
				$startDate = $this->params['url']['startDate'];
			}
			if (isset($this->params['url']['endDate'])) {
				$endDate = $this->params['url']['endDate'];
			}
		} else {
			$startDate = strtotime($this->cleanupDate($this->data['Statistics']['startDate']));
			$endDate = strtotime($this->cleanupDate($this->data['Statistics']['endDate']));

			$this->Session->write($sessKeyStart, $startDate);
			$this->Session->write($sessKeyEnd, $endDate);
		}

		if ($startDate > $endDate) {
			$msg = __('Sorry, the beginning date must be before the end date.', true);
			$this->User->invalidate('startDate', __($msg, true));
		}

		$this->startDate = date('Y-m-d', $startDate);
		$this->endDate = date('Y-m-d', $endDate);
		$this->set(compact('startDate', 'endDate'));
	}
}
?>