<?php
class UsersController extends AppController {
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
		$user = $this->User->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$user = $this->User->find('first', array(
				'conditions' => array('User.id' => $id),
				'contain' => false
			));
			Assert::notEmpty($user, '404');
			Assert::true(User::allowed($this->name, $this->action, $user), '403');
			$action = 'edit';
		}
		$this->set(compact('action', 'user'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $user;
		}

		if ($action == 'add') {
			$this->data['User']['office_id'] = $this->Session->read('Office.id');
		}
		$this->data['Contact']['email'] = $this->data['User']['login'];

		if (!$this->User->saveAll($this->data)) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		if ($action == 'add') {
			$userId = $this->User->id;

			$pwData = $this->User->generatePassword();
			$password = $pwData[0];
			$this->User->set(array(
				'id' => $userId,
				'password' => $pwData[1]
			));
			$this->User->save(null, false);

			$options = array(
				'mail' => array(
					'to' => $this->data['User']['login'],
					'subject' => 'New Account for Greenpeace White Rabbit'
				),
				'vars' => array(
					'url' => Configure::read('App.domain'),
					'password' => $password
				)
			);
			Mailer::deliver('created_admin', $options);

			$msg = 'The admin account for ' . $this->data['User']['login'] . ' has been created successfully. ';
			$msg .= 'An email has been sent to the email address.';
			$url = array('action' => 'admin_edit', $userId);
			return $this->Message->add(__($msg, true), 'ok', true, $url);
		}

		$msg = 'User was saved successfully.';
		$this->Message->add(__($msg, true), 'ok', true, array('action' => 'admin_team'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate = array(
			'conditions' => array(
				'User.login <>' => Configure::read('App.guestAccount')
			),
			'contain' => false
		);
		$users = $this->paginate();
		$this->set(compact('users'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id = null) {
		$user = $this->User->find('first', $id);
		$this->User->delete($id);
		$this->Silverpop->UserOptOut($user);
		$this->Message->add(DEFAULT_FORM_DELETE_SUCCESS, 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $id),
			'contain' => false
		));
		$this->set(compact('user'));
	}
}
?>