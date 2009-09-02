<?php
class TransactionsController extends AppController {
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
	function admin_index($contactId = null) {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id'),
			'Transaction.parent_id' => ''
		);

		$contact = false;
		if (!empty($contactId)) {
			$contact = $this->Contact->find('first', array(
				'conditions' => compact('id'),
				'fields' => array('salutation', 'fname', 'lname', 'title')
			));
			
			$giftIds = $this->Gift->find('all', array(
				'conditions' => array('contact_id' => $contactId),
				'fields' => 'id'
			));
			$conditions['Transaction.gift_id'] = Set::extract('/Gift/id', $giftIds);
		}

		$defaults = array(
			'keyword' => '',
			'search_type' => 'all',
			'start_date' => false,
			'end_date' => false,
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

		$this->Transaction->del($id);
		$msg = __('The Transaction has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>