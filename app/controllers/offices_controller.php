<?php
class OfficesController extends AppController {
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Office']['order'] = array('Office.name' => 'asc');
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
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$office = $this->Office->find('first', array(
				'Office.id' => $id,
				'contain' => false,
			));
			Assert::notEmpty($office, '404');
			$action = 'edit';
		}

		$gateways = $this->Office->Gateway->find('list');
		$this->set(compact('action', 'gateways'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $office;
		}

		if ($action == 'add') {
			$this->data['Office']['user_id'] = User::get('id');
		}

		$this->Office->set($this->data['Office']);
		$result = $this->Office->save();
		if ($this->Office->validationErrors) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}
		Assert::notEmpty($result);

		$msg = 'Office was saved successfully.';
		if ($action == 'add') {
			$url = array('action' => 'admin_edit', $this->Office->id);
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
}
?>