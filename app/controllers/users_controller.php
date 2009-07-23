<?php
class UsersController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function forgot_pw() {
		Assert::true(User::isGuest(), '403');
		if ($this->isGet()) {
			return;
		}

		$user = $this->User->find('first', array(
			'conditions' => array('User.login' => $this->data['User']['login']),
			'contain' => false
		));
		if (empty($user)) {
			$msg = __('Sorry, but we have no record of an account for ' . $this->data['User']['login'] . '.');
			$this->set('response', $msg);
			return $this->render('response');
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
			),
			'mail' => array(
				'to' => $user['User']['login']
				, 'subject' => Configure::read('App.name') . ' Password Recovery'
				, 'template' => 'forgot_pw'
			)
		);
		Mailer::deliver('forgot_pw', $emailSettings);
		$msg = __('A message has been sent to ' . $user['User']['username'] . '.', true);
		$this->Message->add($msg, 'ok');

	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function checkLogin() {
		$response = 'true';
		$name = trim($this->params['url']['data']['User']['login']);
		$isMyName = User::get('User.login') == $name;

		$isTaken = $this->User->hasAny(array('LOWER(login)' => low($name)));
		if ($isTaken && !$isMyName) {
			$response = 'false';
		}

		$this->set(compact('response'));
		$this->render('response', 'ajax');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function register($email = '') {
		$countries = $this->User->Country->find('list');
		$email = isset($this->params['url']['email'])
					? $this->params['url']['email']
					: '';
		$this->set(compact('countries', 'email'));

		if ($this->isGet()) {
			return;
		}

		$this->data['User']['level'] = 'user';
		$this->data['User']['login'] = trim($this->data['User']['login']);

		if ($this->data['User']['eula'] != 1) {
			$msg = __('You have to accept the terms of conditions.', true);
			return $this->Message->add($msg, 'error');
		}

		App::import('Vendor', 'recaptchalib');
		$privatekey = Configure::read('App.recaptcha_privkey');
		$resp = recaptcha_check_answer(
			$privatekey, $_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]
		);
		if (!$resp->is_valid) {
			$msg = __('Sorry, you have not inserted the proper anti spam code.');
			return $this->Message->add($msg, 'error');
		}

		$useEmailActivation = Configure::read('App.use_email_activation');
		if (!$useEmailActivation) {
			$this->data['User']['active'] = '1';
		}

		$this->User->create($this->data);
		if (!$this->User->validates()) {
			$errorMsgs = join('. ', $this->User->validationErrors);
			return $this->Message->add(DEFAULT_FORM_ERROR . ' ' . $errorMsgs, 'error');
		}

		$this->User->set(array(
			'password' => User::hashPw($this->data['User']['password'])
			, 'repeat_password' => User::hashPw($this->data['User']['repeat_password'])
		));

		Assert::notEmpty($this->User->save(), 'save');
		$id = $this->User->getLastInsertId();
		$this->User->handleReferral($id);
		$this->User->referral_key($id, true);
	
		// $this->Silverpop->UserSignUp(); // signup for newsletter (real time)
	
		$msg = __('Thank you for signing up! You are now logged in.', true);
		$url = array('controller' => 'users', 'action' => 'dashboard');
		if ($useEmailActivation) {
			$this->User->activationEmail($this->User->id, $this->data);
			$msg = 'Thank you for signing up! To activate your account, please click on the link in the email sent to you.';
			$msg .= ' Make sure to check your spam folder, too.';
			$msg = __($msg, true);
			$url = array('controller' => 'users', 'action' => 'register');
		} else {
			User::login($id, true, true);
		}
		$this->Message->add($msg, 'ok', true, $url, array('forceNonAjax' => true, 'dontShow' => true));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function edit() {
		$countries = $this->User->Country->find('list');
		$this->set(compact('countries'));

		if ($this->isGet()) {
			return $this->data = User::get();
		}

		$this->data['User']['id'] = User::get('id');
		$this->User->set($this->data);
		if ($this->User->save()) {
			User::restore();
			$this->Message->add(__('Your profile has been updated.', true), 'ok', true, array('action'=>'dashboard'));
		}
		$this->Message->add(__('There was an error updating your profile.', true), 'error', true, $this->referer());
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function captcha() {
		$this->layout = 'captcha';
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
	function edit_password() {
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
			return $this->Message->add(__('Your password has been updated successfully.', true), 'ok');
		}
		$messages = $this->User->validationErrors;
		$this->Message->add(join(', ', $messages), 'error');
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
			'conditions' => array('User.login' => $this->data['User']['login']),
			'contain' => false,
			'fields' => array('User.id', 'User.login', 'User.active')
		));

		if (!empty($user) && $user['User']['active'] == '0') {
			$authKey = AuthKey::generate(
				array('user_id' => $user['User']['id'], 'auth_key_type_id' => 'Account Activation')
			);

			$emailSettings = array(
				'vars' => array(
					'id' => $user['User']['id']
					, 'authKey' => $authKey
				),
				'mail' => array(
					'to' => $user['User']['login']
					, 'subject' => 'Welcome to ' . Configure::read('App.name')
				)
			);
			Mailer::deliver('register', $emailSettings);
		}

		$msg = 'A new activation email was sent to you. Make sure to check your spam/junk folders, too.';
		$this->Message->add(__($msg, true), 'ok', true, $this->referer());
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function delete($id = null) {
		$this->User->delete(User::get('id'));
		$this->Silverpop->UserOptOut();
		User::logout();
		$msg = __('Your account was successfully deleted.', true);
		$this->Message->add($msg, 'ok', true, '/');
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