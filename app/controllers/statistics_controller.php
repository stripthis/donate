<?php
/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class StatisticsController extends AppController {
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
	function gifts() {
		$createdGifts = $this->Gift->find('all', array(
			'conditions' => $this->_conditions(),
			'contain' => false,
			'fields' => array('created', 'amount')
		));

		$months = Common::months($this->startDate, $this->endDate, false);
		$result = array();
		foreach ($months as $month) {
			$result[$month] = array();
			foreach ($createdGifts as $gift) {
				if (Common::sameMonth($gift['Gift']['created'], $month)) {
					$result[$month][] = $gift;
				}
			}
		}
		$this->set(compact('result', 'createdGifts', 'months'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function users() {
		$result = array();
		$users = $this->User->find('all', array(
			'contain' => false,
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
		return array(
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
			$startDate = strtotime($this->cleanupDate($this->data['Inquiry']['startDate']));
			$endDate = strtotime($this->cleanupDate($this->data['Inquiry']['endDate']));

			$this->Session->write($sessKeyStart, $startDate);
			$this->Session->write($sessKeyEnd, $endDate);
		}

		if ($startDate > $endDate) {
			$this->User->invalidate('startDate', 'Sorry, the beginning date must be before the end date.');
		}

		$this->startDate = date('Y-m-d', $startDate);
		$this->endDate = date('Y-m-d', $endDate);
		$this->set(compact('startDate', 'endDate'));
	}
}
?>