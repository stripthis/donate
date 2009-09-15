<?php
class RolesController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->User = $this->Role->User;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$uneditableRoles = $this->Role->unEditable;
		$conditions = Common::multiNegativeCondition('Role.name', $uneditableRoles);
		$roles = $this->Role->find('all', array(
			'conditions' => $conditions,
			'order' => array('Role.name' => 'asc')
		));

		$users = $this->User->find('all', array(
			'conditions' => $conditions,
			'contain' => array('Role(id, name)', 'Office(name)'),
			'fields' => array('User.id', 'User.name'),
			'order' => array('User.name' => 'asc')
		));
		$this->set(compact('roles', 'uneditableRoles', 'users'));

		if ($this->isGet()) {
			return;
		}

		$userIds = array();
		foreach ($this->data['User'] as $id => $roleId) {
			$userIds[] = $id;
			$this->User->set(array('id' => $id, 'role_id' => $roleId));
			$this->User->save();
		}
		$this->Session->logout($userIds);
		
		$msg = __('Permission saved!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
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
		$role = $this->Role->create();

		$action = 'add';
		if ($this->action == 'admin_edit') {
			$role = $this->Role->find('first', array(
				'conditions' => array('Role.id' => $id),
			));
			Assert::notEmpty($role, '404');
			Assert::false(in_array($role['Role']['name'], $this->Role->unEditable), '403');
			$action = 'edit';
		}

		$this->set(compact('action', 'role'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $role;
		}

		$this->Role->set($this->data['Role']);
		if (!$this->Role->save()) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$msg = __('Role was saved successfully.', true);
		$this->Message->add(__($msg, true), 'ok', true, array('action' => 'admin_index'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_delete($id) {
		$role = $this->Role->find('first', array(
			'conditions' => array('Role.id' => $id),
		));
		Assert::notEmpty($role, '404');
		Assert::false(in_array($role['Role']['name'], $this->Role->unEditable), '403');

		$this->Role->del($id);
		$msg = __('Role was successfully removed.', true);
		$this->Message->add(__($msg, true), 'ok', true, array('action' => 'admin_index'));
	}
}
?>