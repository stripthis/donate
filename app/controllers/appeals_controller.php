<?php
class AppealsController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Country = $this->Appeal->Country;
	}
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');
		$this->paginate['Appeal'] = array(
			'conditions' => array(
				'Appeal.office_id' => $this->Session->read('Office.id')
			),
			'contain' => array('User(id, login)', 'Country(name)'),
			'order' => array('Appeal.name' => 'asc')
		);
		$appeals = $this->paginate($this->Appeal);
		$this->set(compact('appeals'));
	}
/**
 * view action
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

		$appeal = $this->Appeal->find('first', array(
			'conditions' => array('Appeal.id' => $id),
			'contain' => array('Parent', 'User', 'Country')
		));
		Assert::notEmpty($appeal, '404');
		$this->set(compact('appeal'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_add() {
		Assert::true(User::allowed($this->name, $this->action), '403');
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
		$appeal = $this->Appeal->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$appeal = $this->Appeal->find('first', array(
				'conditions' => array('Appeal.id' => $id),
				'contain' => false,
			));
			Assert::notEmpty($appeal, '404');
			Assert::true(User::allowed($this->name, $this->action, $appeal), '403');
			$action = 'edit';
		}

		$countryOptions = $this->Country->find('list');
		$this->set(compact('action', 'countryOptions'));
		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

		$this->data['Appeal']['office_id'] = $this->Session->read('Office.id');
		$this->Appeal->set($this->data['Appeal']);
		$result = $this->Appeal->save();
		if ($this->Appeal->validationErrors) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}
		Assert::notEmpty($result);

		$msg = __('Appeal was saved successfully.', true);
		if ($action == 'add') {
			$url = array('action' => 'admin_edit', $this->Appeal->id);
			return $this->Message->add($msg, 'ok', true, $url);
		}
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
/**
 * delete action
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$appeal = $this->Appeal->find('first', array(
			'conditions' => compact('id'),
			'contain' => false
		));
		Assert::notEmpty($appeal, '404');
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

		$this->Appeal->del($id);
		$msg = __('The Appeal has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>