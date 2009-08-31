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
				'contain' => false,
				'fields' => array('salutation', 'fname', 'lname', 'title')
			));
			
			$giftIds = $this->Gift->find('all', array(
				'conditions' => array('contact_id' => $contactId),
				'contain' => false,
				'fields' => 'id'
			));
			$conditions['Transaction.gift_id'] = Set::extract('/Gift/id', $giftIds);
		}

		$keyword = isset($this->params['url']['keyword'])
					? $this->params['url']['keyword']
					: '';
		$searchType = isset($this->params['url']['search_type'])
					? $this->params['url']['search_type']
					: 'all';
		$startDate = isset($this->params['url']['start_date'])
					? $this->params['url']['start_date']
					: false;
		$endDate = isset($this->params['url']['end_date'])
					? $this->params['url']['end_date']
					: false;
		$limit = isset($this->params['url']['my_limit'])
					? $this->params['url']['my_limit']
					: 20;
		$customLimit = isset($this->params['url']['custom_limit'])
					? $this->params['url']['custom_limit']
					: false;
		if (is_numeric($customLimit)) {
			if ($customLimit > 75) {
				$customLimit = 75;
			}
			$limit = $customLimit;
		}

		// search was submitted
		if (!empty($keyword)) {
			$keyword = trim($keyword);
			switch ($searchType) {
				default:
					$conditions['Transaction.serial LIKE'] = '%' . $keyword . '%';
					break;
			}
		}

		if (!empty($startDate)) {
			$conditions['Transaction.created >='] = $startDate;
		}
		if (!empty($endDate)) {
			$conditions['Transaction.created <='] = $endDate;
		}

		$this->paginate['Transaction'] = array(
			'conditions' => $conditions,
			'order' => array('Transaction.created' => 'desc'),
			'contain' => array(
				'Gift',
				'Gateway',
				'ChildTransaction.Gateway',
				'ChildTransaction.Gift',
				'ParentTransaction'
			),
			'limit' => $limit
		);
		$transactions = $this->paginate($this->Transaction);

		$this->set(compact(
			'transactions', 'contact', 'type', 'searchType', 'keyword', 'limit', 'customLimit',
			'startDate', 'endDate'
		));
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
		Assert::true(User::allowed($this->name, $this->action,$transaction), '403');
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