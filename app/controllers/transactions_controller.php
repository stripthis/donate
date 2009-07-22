<?php
class TransactionsController extends AppController {
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Transaction']['order'] = array('Transaction.id' => 'asc');
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