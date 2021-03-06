<?php
class OfficesController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Gift = ClassRegistry::init('Gift');
		$this->Gateway = $this->Office->Gateway;
		$this->Frequency = $this->Office->Frequency;
		$this->Language = $this->Office->Language;
		$this->Currency = $this->Office->Currency;
	}
/**
 * undocumented function
 *
 * @param string $officeId
 * @return void
 * @access public
 */
	function admin_activate($officeId = null) {
		if ($officeId == Configure::read('Office.id')) {
			$msg = __('This office is already active.', true);
			return $this->Message->add($msg, 'ok');
		}

		Assert::true(Office::isOwn($officeId), '403');

		$office = $this->Office->find('first', array(
			'conditions' => array('Office.id' => $officeId),
			'contain' => array('SubOffice', 'ParentOffice')
		));
		Assert::notEmpty($office, '404');

		$this->Office->activate($office['Office']['id']);
		$msg = __('The office was successfully activated!', true);
		return $this->Message->add($msg, 'ok', true, Controller::referer());
	}
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Office'] = array(
			'contain' => array('ParentOffice(name)'),
			'order' => array(
				'Office.parent_id' => 'asc',
				'Office.name' => 'asc'
			)
		);
		$offices = $this->paginate($this->Office);
		$this->set(compact('offices'));
	}
/**
 * view action
 *
 * @param string $id the office id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		if (!User::is('root')) {
			$id = $this->Session->read('Office.id');
		}
		$office = $this->Office->find('first', array(
			'conditions' => array('Office.id' => $id),
			'contain' => array('ParentOffice', 'Gateway')
		));
		Assert::notEmpty($office, '404');
		$this->set(compact('office'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_team() {
		$this->paginate['User'] = array(
			'conditions' => array(
				'User.office_id' => $this->Session->read('Office.id')
			),
			'contain' => array('CreatedBy'),
			'order' => array('User.level' => 'asc'),
			'fields' => array(
				'User.name', 'User.level', 'User.created',
				'User.created_by', 'CreatedBy.login'
			)
		);
		$users = $this->paginate('User');
		$this->set(compact('users'));
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
		$action = 'add';
		if ($this->action == 'admin_edit') {
			if (!User::is('root')) {
				$id = $this->Session->read('Office.id');
			}

			$office = $this->Office->find('first', array(
				'conditions' => array('Office.id' => $id),
				'contain' => array(
					'GatewaysOffice(gateway_id)',
					'FrequenciesOffice(frequency_id)',
					'LanguagesOffice(language_id)',
					'CurrenciesOffice(currency_id)'
				)
			));
			Assert::notEmpty($office, '404');
			Assert::true(User::allowed($this->name, $this->action, $office));
			$action = 'edit';
		} else {
			$office = $this->Office->create();
		}

		$frequencyOptions = $this->Frequency->find('list', array(
			'fields' => array('id', 'humanized')
		));
		$languageOptions = $this->Language->find('list', array(
			'fields' => array('id', 'code')
		));
		$currencyOptions = $this->Currency->find('list', array(
			'fields' => array('id', 'iso_code')
		));
		$gatewayOptions = $this->Gateway->find('list');

		$this->set(compact(
			'action', 'office', 'gatewayOptions',
			'frequencyOptions', 'languageOptions', 'currencyOptions'
		));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $office;
		}

		if ($action == 'add') {
			$this->data['Office']['user_id'] = User::get('id');
		}

		$this->Office->set($this->data);
		if (!$this->Office->save()) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$msg = __('Office was saved successfully.', true);
		$url = User::allowed('Offices', 'admin_index')
				? array('action' => 'index')
				: $this->referer();
		$this->Message->add($msg, 'ok', true, $url);
	}
/**
 * delete action
 *
 * @param string $id the office id
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$office = $this->Office->find('first', array(
			'conditions' => compact('id'),
			'contain' => array('User', 'Gift')
		));
		Assert::notEmpty($office, '404');

		$noUsers = empty($office['User']);
		$noGifts = empty($office['Gift']);
		$url = array('action' => 'index');
		if (!$noGifts || !$noUsers) {
			$msg = __('Sorry, but there are still users, transactions or gifts related to this office.', true);
			$this->Message->add($msg, 'error', true, $url);
		}
		$this->Office->del($id);
		$msg = __('The Office has been deleted.', true);
		$this->Message->add($msg, 'ok', true, $url);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_manage_tree() {
		Assert::true(User::is('root'), '403');
		$treeOffices = $this->Office->find('threaded', array(
			'order' => array('name' => 'asc'),
			'fields' => array('parent_id', 'id', 'name')
		));
		$offices = $this->Office->find('all', array(
			'order' => array('name' => 'asc'),
			'fields' => array('parent_id', 'id', 'name')
		));
		$this->set(compact('offices', 'treeOffices'));
		if ($this->isGet()) {
			return;
		}

		foreach ($this->data['options'] as $id => $parentId) {
			$this->Office->set(array('id' => $id, 'parent_id' => $parentId));
			$this->Office->save(null, false);
		}
		$msg = __('Tree updated!', true);
		$this->Message->add($msg, 'ok', true, $this->here);
	}
}
?>