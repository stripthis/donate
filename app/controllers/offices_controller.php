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

		$this->Office->activate($office);
		$msg = __('The office was successfully activated!', true);
		return $this->Message->add($msg, 'ok');
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
		$office = $this->Office->find('first', array(
			'conditions' => array('Office.id' => $id),
			'contain' => false
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
		$office = $this->Office->create();
		$selectedGateways = array();

		$action = 'add';
		if ($this->action == 'admin_edit') {
			$office = $this->Office->find('first', array(
				'conditions' => array('Office.id' => $id),
				'contain' => array('GatewaysOffice(gateway_id)')
			));
			Assert::notEmpty($office, '404');
			Assert::true(Office::isOwn($id), '403');

			$selectedGateways = Set::extract('/GatewaysOffice/gateway_id', $office);
			$action = 'edit';
		}

		$gatewayOptions = $this->Gateway->find('list');
		$this->treeSelections($id);
		$gateways = $this->Office->Gateway->find('list');
		$this->set(compact('action', 'office', 'gateways', 'gatewayOptions', 'selectedGateways'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $office;
		}

		if ($action == 'add') {
			$this->data['Office']['user_id'] = User::get('id');
		}

		$this->Office->set($this->data['Office']);
		if (!$this->Office->save()) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$officeId = $this->Office->id;
		if (User::isRoot()) {
			$this->Office->subRelations($officeId, $this->data);
		}
		$this->Office->reload($officeId);

		$msg = 'Office was saved successfully.';
		if ($action == 'add') {
			$url = array('action' => 'admin_edit', $officeId);
			return $this->Message->add(__($msg, true), 'ok', true, $url);
		}
		$this->Message->add(__($msg, true), 'ok', true, array('action' => 'admin_index'));
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
			'contain' => false
		));
		Assert::notEmpty($office, '404');

		$this->Office->del($id);
		$this->Message->add(__('The Office has been deleted.', true), 'ok', true);
		$this->redirect(array('action' => 'admin_index'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	private function treeSelections($id) {
		if (User::isRoot()) {
			$parentOptions = $this->Office->parentOfficeOptions($id);
			$subOptions = $this->Office->subOfficeOptions($id);
			$selectedSubs = $this->Office->subOfficeOptions($id, 'selected');
			$this->set(compact('parentOptions', 'subOptions', 'selectedSubs'));
		}
	}
}
?>