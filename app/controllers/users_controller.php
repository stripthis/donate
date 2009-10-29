<?php
class UsersController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Office = $this->User->Office;
		$this->Language = $this->Office->Language;
		$this->Role = $this->User->Role;
		$this->ReportsUser = $this->User->ReportsUser;
		$this->Report = $this->ReportsUser->Report;
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
		$user = $this->User->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$user = $this->User->find('first', array(
				'conditions' => array('User.id' => $id),
				'contain' => array('Contact', 'Role')
			));
			Assert::notEmpty($user, '404');
			Assert::true(User::allowed($this->name, $this->action, $user), '403');
			$action = 'edit';
		}

		$officeOptions = $this->Office->find('root_options');
		$roleOptions = $this->Role->find('options');
		$this->set(compact('action', 'user', 'officeOptions', 'roleOptions'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $user;
		}

		if (!$this->User->saveAll($this->data)) {
			$msg = __('Please fill out all fields', true);
			return $this->Message->add($msg, 'error');
		}

		if ($action == 'add') {
			$password = $this->User->savePassword();
			$this->User->sendNewAccountEmail($password, $this->data);

			$msg = sprintf(
				__(
					'The admin account for %s has been created successfully. 
					An email has been sent to the email address.'
				, true),
				$this->data['User']['login']
			);
			return $this->Message->add($msg, 'ok', true, array('action' => 'index'));
		}

		$msg = __('User was saved successfully.', true);
		$this->Message->add(__($msg, true), 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index($type = '') {
		$params = $this->_parseGridParams();
		$conditions = $this->_conditions($params);

		$this->paginate = array(
			'conditions' => $conditions,
			'contain' => array('Role(name)', 'CreatedBy(login)', 'ModifiedBy(login)'),
			'order' => array('Role.name' => 'desc', 'User.login' => 'asc'),
			'limit' => $params['my_limit']
		);
		$users = $this->paginate();
		$this->set(compact('users', 'params', 'type'));
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
		$msg = __('Successfully deleted!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_forgot_pw() {
		Assert::true(User::is('guest'), '403');
		$this->layout = 'admin_login';
		if ($this->isGet()) {
			return;
		}

		$user = $this->User->find('first', array(
			'conditions' => array('User.login' => $this->data['User']['login'])
		));

		if (empty($user)) {
			$msg = __('Sorry, but we have no record of an account for ' . $this->data['User']['login'] . '.', true);
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
				, 'subject' => __(Configure::read('App.name') . ' Password Recovery', true)
				, 'template' => 'forgot_pw'
				, 'delivery' => 'debug'
			)
		);
		Mailer::deliver('forgot_pw', $emailSettings);
		Common::debugEmail();
		$msg = sprintf(__('A message has been sent to %s.', true), $user['User']['login']);
		$this->Message->add($msg, 'ok');
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
	function admin_activate($id = null) {
		$authKey = Common::defaultTo($this->params['named']['auth_key'], null);
		Assert::notEmpty($id, '404');
		Assert::notEmpty($authKey, '404');
		$this->User->set(compact('id'));
		Assert::true($this->User->exists(), '404');

		$contain = false;
		$conditions = array('User.id' => $id);
		$user = $this->User->find('first', compact('conditions', 'contain'));

		Assert::false(!!$user['User']['active'], 'user_already_activated');
		Assert::true(AuthKey::verify($authKey, $user['User']['id'], 'Account Activation'), '403');

		$this->User->set(array('id' => $id, 'active' => 1));
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
	function admin_resend_activation_email($userId = false) {
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $userId),
			'fields' => array('User.id', 'User.login', 'User.active')
		));

		Assert::equal($user['User']['active'], '0', '404');
		if (!empty($user) && $user['User']['active'] == '0') {
			$this->id = $user['User']['id'];
			$this->User->activationEmail($user['User']['id'], $user);
		}

		$msg = __('A new activation email was sent.', true);
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
			$msg = __('Your password has been updated successfully.', true);
			return $this->Message->add($msg, 'ok');
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
		$langOptions = $this->Language->find('options', array('all' => true));
		$this->set(compact('langOptions'));

		if ($this->isGet()) {
			return $this->data = User::get();
		}

		$this->data['User']['id'] = User::get('id');
		if (!$this->User->saveAll($this->data)) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		User::restore();
		$this->_setLanguage(User::get('lang'));

		$this->Message->add(__('Saved successfully.', true), 'ok', true, $this->here);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_public_key($id = null) {
		if ($this->isGet()) {
			return $this->data = User::get();
		}

		$this->data['User']['id'] = User::get('id');
		if (!$this->User->save($this->data)) {
			return $this->Message->add(__('There was a problem with the form.', true), 'error');
		}
		User::restore();

		$this->Message->add(__('Saved successfully.', true), 'ok', true, $this->here);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_email_reports($id = null) {
		Assert::true(User::allowed($this->name, $this->action), '403');

		$this->paginate['Report'] = array(
			'contain' => false,
			'order' => array('frequency' => 'asc', 'title' => 'asc')
		);
		$reports = $this->paginate('Report');

		$myReports = $this->ReportsUser->find('all', array(
			'conditions' => array('ReportsUser.user_id' => User::get('id')),
			'contain' => false,
			'fields' => array('report_id')
		));
		$myReports = Set::extract('/ReportsUser/report_id', $myReports);
		$this->set(compact('reports', 'myReports'));

		if ($this->isGet()) {
			return;
		}

		$this->data['User']['id'] = User::get('id');
		if (!$this->User->save($this->data, false)) {
			return $this->Message->add(__('There was a problem with the form.', true), 'error');
		}
		$this->Message->add(__('Saved successfully.', true), 'ok', true, $this->here);
	}
/**
 * undocumented function
 *
 * @param string $params 
 * @return void
 * @access public
 */
	function _conditions($params) {
		$conditions = array(
			'User.login <>' => Configure::read('App.emails.guestAccount'),
			'User.active' => '1'
		);

		if (!User::is('root')) {
			$conditions['User.office_id'] = $this->Session->read('Office.id');
			if ($type == 'unactivated') {
				$conditions['User.active'] = '0';
			}
		} elseif (!empty($type)) {
			$conditions['User.office_id'] = $type;
		}
		$conditions = $this->User->dateRange($conditions, $params, 'created');

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
		return $conditions;
	}
}
?>