<?php
class AppealsController extends AppController {

	var $name = 'Appeals';
	var $helpers = array('Html', 'Form');
/**
 * index action
 *
 * @return void
 * @access public
 */
	function index() {
		$this->paginate['Appeal']['order'] = array('Appeal.name' => 'asc');
		$this->paginate['Appeal'] = am(Configure::read('App.pagination'), $this->paginate['Appeal']);
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
	function view($id = null) {
		$this->Appeal->set('id', $id);
		Assert::true($this->Appeal->exists(), '404');

		$conditions = array('Appeal.id' => $id);
		$contain = false;
		$appeal = $this->Appeal->find('first', compact('conditions', 'contain'));
		$this->set(compact('appeal'));
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
		$appeal = $this->Appeal->create();
		$action = 'add';
		if ($this->action == 'edit') {
			$this->Appeal->set(compact('id'));
			Assert::true($this->Appeal->exists(), '404');
			$appeal = $this->Appeal->find('first', array(
				'Appeal.id' => $id,
				'contain' => false,
			));
			$action = 'edit';
		}
		$parents = $this->Appeal->Parent->find('list');

		$users = $this->Appeal->User->find('list');

		$countries = $this->Appeal->Country->find('list');

		$this->set(compact('action'));
		$this->action = 'edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

		$result = $this->Appeal->save($this->data['Appeal']);
		if ($this->Appeal->validationErrors) {
			return $this->Message->add('Please fill out all fields', 'error');
		}
		Assert::notEmpty($result);
		if ($action == 'add') {
			$this->Message->add('New Appeal _'.$result['Appeal']['name'].'_ was added successfully.', 'ok', true);
			return $this->redirect(array('action' => 'edit', $this->Appeal->id));
		}
		$this->Message->add('Appeal was saved successfully.', 'ok', true);
		$this->redirect(array('action' => 'index'));
	}
/**
 * delete action
 *
 * @param string $id the appeal id
 * @param boolean if the appeal should be deleted or undeleted
 * @return void
 * @access public
 */
	function delete($id = null, $undelete = false) {
		$this->Appeal->set(compact('id'));
		Assert::true($this->Appeal->exists(), '404');
		
		$conditions = compact('id');
		$recursive = -1;
		$appeal = $this->Appeal->find('first', compact('conditions', 'recursive'));
		Assert::true(AppModel::isOwn($appeal, 'Appeal'), '403');

		if (!$undelete) {
			$this->Appeal->del($id);
			$this->Message->add('The Appeal has been deleted.', 'ok', true);
		} else {
			$this->Appeal->undelete($id);
			$this->Message->add('The Appeal has been undeleted.', 'ok', true);
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
		$this->paginate['Appeal']['order'] = array('Appeal.name' => 'asc');
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
		$this->Appeal->set('id', $id);
		Assert::true($this->Appeal->exists(), '404');

		$conditions = array('Appeal.id' => $id);
		$contain = false;
		$appeal = $this->Appeal->find('first', compact('conditions', 'contain'));
		$this->set(compact('appeal'));
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
		$appeal = $this->Appeal->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$this->Appeal->set(compact('id'));
			Assert::true($this->Appeal->exists(), '404');
			$appeal = $this->Appeal->find('first', array(
				'Appeal.id' => $id,
				'contain' => false,
			));
			$action = 'edit';
		}
		$parents = $this->Appeal->Parent->find('list');

		$users = $this->Appeal->User->find('list');

		$countries = $this->Appeal->Country->find('list');

		$this->set(compact('action'));
		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

		$result = $this->Appeal->save($this->data['Appeal']);
		if ($this->Appeal->validationErrors) {
			return $this->Message->add('Please fill out all fields', 'error');
		}
		Assert::notEmpty($result);
		if ($action == 'add') {
			$this->Message->add('New Appeal _'.$result['Appeal']['name'].'_ was added successfully.', 'ok', true);
			return $this->redirect(array('action' => 'admin_edit', $this->Appeal->id));
		}
		$this->Message->add('Appeal was saved successfully.', 'ok', true);
		$this->redirect(array('action' => 'admin_index'));
	}
/**
 * delete action
 *
 * @param string $id the appeal id
 * @param boolean if the appeal should be deleted or undeleted
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$this->Appeal->set(compact('id'));
		Assert::true($this->Appeal->exists(), '404');
		
		$conditions = compact('id');
		$recursive = -1;
		$appeal = $this->Appeal->find('first', compact('conditions', 'recursive'));
		Assert::true(AppModel::isOwn($appeal, 'Appeal'), '403');

		if (!$undelete) {
			$this->Appeal->del($id);
			$this->Message->add('The Appeal has been deleted.', 'ok', true);
		} else {
			$this->Appeal->undelete($id);
			$this->Message->add('The Appeal has been undeleted.', 'ok', true);
		}

		$this->redirect(array('action' => 'admin_index'));
	}
}
?>