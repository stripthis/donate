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
				'conditions' => array('User.id' => $id)
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
		$conditions = array(
			'User.login <>' => Configure::read('App.guestAccount'),
			'User.active' => '1'
		);

		$defaults = array(
			'keyword' => '',
			'search_type' => 'all',
			'my_limit' => 20,
			'custom_limit' => false
		);
		$params = am($defaults, $this->params['url'], $this->params['named']);

		if (is_numeric($params['custom_limit'])) {
			if ($params['custom_limit'] > 75) {
				$params['custom_limit'] = 75;
			}
			if ($params['custom_limit'] == 0) {
				$params['custom_limit'] = 50;
			}
			$params['my_limit'] = $params['custom_limit'];
		}

		// search was submitted
		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);

			switch ($params['search_type']) {
				case 'name':
					$conditions['User.name LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'email':
					$conditions['User.login LIKE'] = '%' . $params['keyword'] . '%';
					break;
				default:
					$conditions['or'] = array(
						'User.name LIKE' => '%' . $params['keyword'] . '%',
						'User.login LIKE' => '%' . $params['keyword'] . '%'
					);
					break;
			}
		}

		$this->paginate = array(
			'conditions' => $conditions,
			'contain' => array('CreatedBy(login)', 'ModifiedBy(login)'),
			'order' => array('User.login' => 'asc'),
			'limit' => $params['my_limit']
		);
		$users = $this->paginate();
		$this->set(compact('users', 'params'));
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
			'conditions' => array('User.id' => $id)
		));
		$this->set(compact('user'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_forgot_pw() {
		Assert::true(User::isGuest(), '403');
		$this->layout = 'admin_login';
		if ($this->isGet()) {
			return;
		}

		$user = $this->User->find('first', array(
			'conditions' => array('User.login' => $this->data['User']['login'])
		));

		if (empty($user)) {
			$msg = 'Sorry, but we have no record of an account for ' . $this->data['User']['login'] . '.';
			return $this->Message->add($msg, 'error');
		}

		$id = $user['User']['id'];
		$authKeyTypeId = $this->User->AuthKey->AuthKeyType->lookup('Lost Password');

		App::import('Model', 'TimeZone');
		$authKey = AuthKey::generate(array(
			'user_id' => $user['User']['id']
			, 'auth_key_type_id' => $authKeyTypeId
			, 'expires' => TimeZone::date('Y-m-d H:i:s', 'UTC', '+3 days')
		));

		$emailSettings = array(
			'vars' => array(
				'id' => $id,
				'authKey' => $authKey,
				'authKeyTypeId' => $authKeyTypeId,
				'name' => $user['User']['name']
			),
			'mail' => array(
				'to' => $user['User']['login']
				, 'subject' => Configure::read('App.name') . ' Password Recovery'
				, 'template' => 'forgot_pw'
				, 'delivery' => 'debug'
			)
		);
		Mailer::deliver('forgot_pw', $emailSettings);
		Common::debugEmail();
		$this->Message->add('A message has been sent to ' . $user['User']['login'] . '.', 'ok');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function checkEmail() {
		$name = trim($this->params['url']['data']['User']['login']);
		$user = $this->User->find('first', array(
			'conditions' => array('LOWER(login)' => low($name))
		));
		$response = empty($user) ? 'true' : 'false';
		$this->set(compact('response'));
		$this->render('response', 'ajax');
	}
/**
 * This action activates a user of a given $id if he has followed the link provided by the welcome email to do so
 * and no issues arise.
 *
 * @param integer $id
 * @return void
 * @access public
 */
	function activate($id = null) {
		$authKey = Common::defaultTo($this->params['named']['auth_key'], null);
		Assert::notEmpty($id, '404');
		Assert::notEmpty($authKey, '404');
		$this->User->set(compact('id'));
		Assert::true($this->User->exists(), '404');

		$contain = false;
		$conditions = array('User.id' => $id);
		$user = $this->User->find('first', compact('conditions', 'contain'));

		Assert::false(!!$user['User']['activated'], 'user_already_activated');
		Assert::true(AuthKey::verify($authKey, $user['User']['id'], 'Account Activation'), '403');

		$this->User->set(array('id' => $id, 'activated' => 1));
		Assert::notEmpty($this->User->save(null, false), 'save');

		AuthKey::expire($authKey);
		User::login($id, true);

		$this->set(compact('user'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function resend_activation_email() {
		if ($this->isGet()) {
			return;
		}

		$user = $this->User->find('first', array(
			'conditions' => array('User.email' => $this->data['User']['email']),
			'fields' => array('User.id', 'User.email', 'User.activated')
		));

		if (!empty($user) && $user['User']['active'] == '0') {
			$this->id = $user['User']['id'];
			$this->User->activationEmail($user['User']['id'], $user);
		}

		$msg = 'A new activation email was sent to you. Make sure to check your spam/junk folders, too.';
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_edit_password() {
		if ($this->isGet()) {
			return;
		}

		$response = '';
		$inLostPasswordProcess = $this->Session->read('lost_password') == true;
		if (!$inLostPasswordProcess && (!isset($this->data['User']['current_password'])
			|| User::get('password') != User::hashPw($this->data['User']['current_password']))) {
			return $this->Message->add('The entered password is wrong.', 'error');
		}

		$this->data['User']['id'] = User::get('id');
		$this->User->set($this->data);

		if ($this->User->validates()) {
			$this->data['User']['password'] = User::hashPw($this->data['User']['password']);
			unset($this->data['User']['current_password']);
			unset($this->data['User']['repeat_password']);
			$this->data['User']['id'] = User::get('id');
			$this->User->set($this->data);
			$this->User->save(null, false);
			User::restore();
			$this->Session->del('lost_password');
			return $this->Message->add('Your password has been updated successfully.', 'ok');
		}
		$messages = $this->User->validationErrors;
		$this->Message->add(join(', ', $messages), 'error');
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_preferences($id = null) {
		if ($this->isGet()) {
			return $this->data = User::get();
		}

		$this->data['User']['id'] = User::get('id');
		if (!$this->User->saveAll($this->data)) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$this->_setLanguage(User::get('lang'));
		User::restore();

		$msg = 'Saved successfully.';
		$this->Message->add(__($msg, true), 'ok', true, $this->here);
	}
}
?>