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
		$conditions = array('Transaction.parent_id' => '');

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

		$this->paginate['Transaction'] = array(
			'conditions' => $conditions,
			'order' => array('Transaction.id' => 'asc'),
			'contain' => array(
				'Gateway',
				'Gift',
				'ChildTransaction.Gateway',
				'ChildTransaction.Gift',
				'ParentTransaction'
			)
		);
		$transactions = $this->paginate($this->Transaction);
		$this->set(compact('transactions', 'contact'));
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
			'contain' => false
		));
		Assert::notEmpty($transaction, '404');
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
			'conditions' => compact('id'),
			'contain' => false
		));
		Assert::notEmpty($transaction, '404');

		$this->Transaction->del($id);
		$msg = __('The Transaction has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>