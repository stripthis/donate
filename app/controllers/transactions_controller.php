<?php
class TransactionsController extends AppController {

	var $name = 'Transactions';
	var $helpers = array('Html', 'Form');
/**
 * index action
 *
 * @return void
 * @access public
 */
	function index() {
		$this->paginate['Transaction']['order'] = array('Transaction.id' => 'asc');
		$this->paginate['Transaction'] = am(Configure::read('App.pagination'), $this->paginate['Transaction']);
		$transactions = $this->paginate($this->Transaction);
		$this->set(compact('transactions'));
	}
/**
 * view action
 *
 * @param string $id the transaction id
 * @return void
 * @access public
 */
	function view($id = null) {
		$this->Transaction->set('id', $id);
		Assert::true($this->Transaction->exists(), '404');

		$conditions = array('Transaction.id' => $id);
		$contain = false;
		$transaction = $this->Transaction->find('first', compact('conditions', 'contain'));
		$this->set(compact('transaction'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function add() {
		$this->edit();
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function edit($id = null) {
		$transaction = $this->Transaction->create();
		$action = 'add';
		if ($this->action == 'edit') {
			$this->Transaction->set(compact('id'));
			Assert::true($this->Transaction->exists(), '404');
			$transaction = $this->Transaction->find('first', array(
				'Transaction.id' => $id,
				'contain' => false,
			));
			$action = 'edit';
		}
		$parentTransactions = $this->Transaction->ParentTransaction->find('list');

		$gateways = $this->Transaction->Gateway->find('list');

		$gifts = $this->Transaction->Gift->find('list');

		$this->set(compact('action'));
		$this->action = 'edit';
		if ($this->isGet()) {
			return $this->data = $transaction;
		}

		if ($action == 'add') {
			$this->data['Transaction']['user_id'] = User::get('id');
		}

		$result = $this->Transaction->save($this->data['Transaction']);
		if ($this->Transaction->validationErrors) {
			return $this->Message->add('Please fill out all fields', 'error');
		}
		Assert::notEmpty($result);
		if ($action == 'add') {
			$this->Message->add('New Transaction _'.$result['Transaction']['id'].'_ was added successfully.', 'ok', true);
			return $this->redirect(array('action' => 'edit', $this->Transaction->id));
		}
		$this->Message->add('Transaction was saved successfully.', 'ok', true);
		$this->redirect(array('action' => 'index'));
	}
/**
 * delete action
 *
 * @param string $id the transaction id
 * @param boolean if the transaction should be deleted or undeleted
 * @return void
 * @access public
 */
	function delete($id = null, $undelete = false) {
		$this->Transaction->set(compact('id'));
		Assert::true($this->Transaction->exists(), '404');
		
		$conditions = compact('id');
		$recursive = -1;
		$transaction = $this->Transaction->find('first', compact('conditions', 'recursive'));
		Assert::true(AppModel::isOwn($transaction, 'Transaction'), '403');

		if (!$undelete) {
			$this->Transaction->del($id);
			$this->Message->add('The Transaction has been deleted.', 'ok', true);
		} else {
			$this->Transaction->undelete($id);
			$this->Message->add('The Transaction has been undeleted.', 'ok', true);
		}

		$this->redirect(array('action' => 'index'));
	}
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Transaction']['order'] = array('Transaction.id' => 'asc');
		$this->paginate['Transaction'] = am(Configure::read('App.pagination'), $this->paginate['Transaction']);
		$transactions = $this->paginate($this->Transaction);
		$this->set(compact('transactions'));
	}
/**
 * view action
 *
 * @param string $id the transaction id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$this->Transaction->set('id', $id);
		Assert::true($this->Transaction->exists(), '404');

		$conditions = array('Transaction.id' => $id);
		$contain = false;
		$transaction = $this->Transaction->find('first', compact('conditions', 'contain'));
		$this->set(compact('transaction'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_add() {
		$this->admin_edit();
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_edit($id = null) {
		$transaction = $this->Transaction->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$this->Transaction->set(compact('id'));
			Assert::true($this->Transaction->exists(), '404');
			$transaction = $this->Transaction->find('first', array(
				'Transaction.id' => $id,
				'contain' => false,
			));
			$action = 'edit';
		}
		$parentTransactions = $this->Transaction->ParentTransaction->find('list');

		$gateways = $this->Transaction->Gateway->find('list');

		$gifts = $this->Transaction->Gift->find('list');

		$this->set(compact('action'));
		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $transaction;
		}

		if ($action == 'add') {
			$this->data['Transaction']['user_id'] = User::get('id');
		}

		$result = $this->Transaction->save($this->data['Transaction']);
		if ($this->Transaction->validationErrors) {
			return $this->Message->add('Please fill out all fields', 'error');
		}
		Assert::notEmpty($result);
		if ($action == 'add') {
			$this->Message->add('New Transaction _'.$result['Transaction']['id'].'_ was added successfully.', 'ok', true);
			return $this->redirect(array('action' => 'admin_edit', $this->Transaction->id));
		}
		$this->Message->add('Transaction was saved successfully.', 'ok', true);
		$this->redirect(array('action' => 'admin_index'));
	}
/**
 * delete action
 *
 * @param string $id the transaction id
 * @param boolean if the transaction should be deleted or undeleted
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$this->Transaction->set(compact('id'));
		Assert::true($this->Transaction->exists(), '404');
		
		$conditions = compact('id');
		$recursive = -1;
		$transaction = $this->Transaction->find('first', compact('conditions', 'recursive'));
		Assert::true(AppModel::isOwn($transaction, 'Transaction'), '403');

		if (!$undelete) {
			$this->Transaction->del($id);
			$this->Message->add('The Transaction has been deleted.', 'ok', true);
		} else {
			$this->Transaction->undelete($id);
			$this->Message->add('The Transaction has been undeleted.', 'ok', true);
		}

		$this->redirect(array('action' => 'admin_index'));
	}
}
?>