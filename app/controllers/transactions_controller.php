<?php
class TransactionsController extends AppController {
	var $components = array('Uploader');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Gift = $this->Transaction->Gift;
		$this->Import = $this->Transaction->Import;
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

		$params = $this->_parseGridParams();
		$conditions = $this->_conditions($params, $type);

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

		$this->Session->write('transactions_filter_conditions', $conditions);
		$this->Transaction->recursive = 1;
		$this->paginate['Transaction'] = array(
			'conditions' => $conditions,
			'order' => array('Transaction.created' => 'desc'),
			'recursive' => 2,
			'contain' => array(
				'Gift',
				'Gateway',
				'Import',
				'ChildTransaction.Gateway',
				'ChildTransaction.Gift',
				'ChildTransaction.Currency(iso_code)',
				'ParentTransaction',
				'Currency(iso_code)'
			),
			'limit' => $params['my_limit']
		);
		$transactions = $this->paginate($this->Transaction);

		$this->set(compact('transactions', 'contact', 'type', 'params'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_stats() {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$params = $this->_parseGridParams();

		$urlData = explode('/', $this->params['url']['link']);
		$type = $urlData[3];
		$conditions = $this->_conditions($params, $type);
		$this->Session->write('transactions_filter_conditions', $conditions);

		$this->set(compact(
			'transactions', 'type', 'params', 'conditions'
		));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_stats_erronous() {
		$conditions = $this->Session->read('transactions_filter_conditions');
		$erronousCount = $this->Transaction->find('count', array(
			'conditions' => am($conditions, array(
				'Transaction.status' => 'error'
			))
		));
		$notErronousCount = $this->Transaction->find('count', array(
			'conditions' => am($conditions, array(
				'Transaction.status <>' => 'error'
			))
		));
		$this->set(compact('erronousCount', 'notErronousCount'));
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
				'Gift.Frequency',
				'Gateway',
				'Currency(iso_code)'
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

		$this->Transaction->set(array('id' => $id, 'archived' => '1'));
		$this->Transaction->save();

		$msg = __('The Transaction has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_import($process = false) {
		if ($this->isGet() && !$process) {
			return;
		}

		if ($this->isPost()) {
			$file = $this->data['Import']['file'];
			unset($this->data['Import']['file']);

			$fileRules = array('text/plain');
			if (!in_array($file['type'], $fileRules)) {
				$msg = __('Sorry, your resume must be a text file.', true);
				return $this->Message->add($msg, 'error');
			}

			$this->data['Import']['user_id'] = User::get('id');
			$this->Import->create($this->data);
			if (!$this->Import->validates()) {
				$msg = __('There was a problem with the form!', true);
				return $this->Message->add($msg, 'error');
			}
		}

		$importId = $import = false;
		if ($process) {
			$this->data = $this->Session->read('import_data');

			$result = $this->Session->read('import_result');
			$this->data['Import']['nb_requested'] = $result['valid'] + $result['invalid_missing_parent'];
			$this->data['Import']['nb_imported'] = $result['valid'];
			$this->data['Import']['user_id'] = User::get('id');

			$this->Import->create($this->data);
			$this->Import->save();
			$importId = $this->Import->getLastInsertId();
			$import = $this->Import->find('first', array(
				'conditions' => array('id' => $importId)
			));

			$myFile = $this->Session->read('import_file');
		} else {
			$myFile = $this->Uploader->upload($file, IMPORTS_PATH, $fileRules);
			$this->Session->write('import_file', $myFile);
			$this->Session->write('import_data', $this->data);
		}

		$result = $this->Import->parseFile(
			$myFile, $this->data['Import']['template'], $process, $importId
		);
		$this->Session->write('import_result', $result);
		$this->set(compact('result', 'process', 'import'));
	}
/**
 * undocumented function
 *
 * @param string $type 
 * @param string $contactId 
 * @return void
 * @access public
 */
	function _conditions($params, $type) {
		$conditions = array(
			'Transaction.office_id' => $this->Session->read('Office.id'),
			'Transaction.parent_id' => '',
			'Transaction.archived' => '0'
		);

		switch ($type) {
			case 'archived':
				$conditions['Transaction.archived'] = '1';
				break;
		}

		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);
			switch ($params['search_type']) {
				case 'import_id':
					$conditions['Import.serial'] = $params['keyword'];
					break;
				default:
					$conditions['Transaction.serial LIKE'] = '%' . $params['keyword'] . '%';
					break;
			}
		}
		$conditions = $this->Transaction->dateRange($conditions, $params, 'created');
		return $conditions;
	}
}
?>