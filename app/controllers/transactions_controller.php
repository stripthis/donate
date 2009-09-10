<?php
class TransactionsController extends AppController {
	var $components = array('GridFilter');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Gift = $this->Transaction->Gift;
		$this->Contact = $this->Gift->Contact;
	}
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index($type = 'all', $contactId = null) {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id'),
			'Transaction.parent_id' => '',
			'Transaction.archived' => '0'
		);

		$contact = false;
		if (!empty($contactId)) {
			$contact = $this->Contact->find('first', array(
				'conditions' => compact('id'),
				'fields' => array('salutation', 'fname', 'lname', 'title')
			));

			$giftIds = $this->Gift->find('all', array(
				'conditions' => array(
					'contact_id' => $contactId,
					'archived' => '0'
				),
				'fields' => 'id'
			));
			$conditions['Transaction.gift_id'] = Set::extract('/Gift/id', $giftIds);
		}

		$defaults = array(
			'keyword' => '',
			'search_type' => 'all',
			'start_date_day' => '01',
			'start_date_year' => date('Y'),
			'start_date_month' => '01',
			'end_date_day' => '31',
			'end_date_year' => date('Y'),
			'end_date_month' => '12',
			'my_limit' => 20,
			'custom_limit' => false
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

		// search was submitted
		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);
			switch ($params['search_type']) {
				default:
					$conditions['Transaction.serial LIKE'] = '%' . $params['keyword'] . '%';
					break;
			}
		}

		if (!empty($params['start_date'])) {
			$conditions['Transaction.created >='] = $params['start_date'];
		}
		if (!empty($params['end_date'])) {
			$conditions['Transaction.created <='] = $params['end_date'];
		}

		$conditions = $this->GridFilter->dateRange($conditions, $params, 'Transaction', 'created');
		$this->Session->write('transactions_filter_conditions', $conditions);
		$this->paginate['Transaction'] = array(
			'conditions' => $conditions,
			'order' => array('Transaction.created' => 'desc'),
			'recursive' => 1,
			'contain' => array(
				'Gift',
				'Gateway',
				'ChildTransaction.Gateway',
				'ChildTransaction.Gift',
				'ParentTransaction'
			),
			'limit' => $params['my_limit']
		);
		$transactions = $this->paginate($this->Transaction);

		$this->set(compact('transactions', 'contact', 'type', 'params'));
	}
/**
 * view action
 *
 * @param string $id the transaction id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$transaction = $this->Transaction->find('first', array(
			'conditions' => array('Transaction.id' => $id),
			'contain' => array(
				'ParentTransaction',
				'Gift.Contact',
				'Gateway'
			)
		));
		Assert::notEmpty($transaction, '404');
		Assert::true(User::allowed($this->name, $this->action, $transaction), '403');
		$this->set(compact('transaction'));
	}
/**
 * delete action
 *
 * @param string $id the transaction id
 * @return void
 * @access public
 */
	function admin_delete($id = null) {
		$transaction = $this->Transaction->find('first', array(
			'conditions' => array('Transaction.id' => $id),
			'contain' => array('Gift')
		));
		Assert::notEmpty($transaction, '404');
		Assert::true(User::allowed($this->name, $this->action, $transaction), '403');

		$this->Transaction->set(array(
			'id' => $id,
			'archived' => '1'
		));
		$this->Transaction->save();
		$msg = __('The Transaction has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>