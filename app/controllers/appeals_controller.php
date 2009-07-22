<?php
class AppealsController extends AppController {
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
		$appeal = $this->Appeal->find('first', array(
			'conditions' => array('Appeal.id' => $id),
			'contain' => false
		));
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
			$appeal = $this->Appeal->find('first', array(
				'conditions' => array('Appeal.id' => $id),
				'contain' => false,
			));
			Assert::notEmpty($appeal, '404');
			$action = 'edit';
		}

		$this->set(compact('action'));
		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

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

		$this->Appeal->del($id);
		$msg = __('The Appeal has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>