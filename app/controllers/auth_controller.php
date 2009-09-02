<?php
class AuthController extends AppController{
	var $uses = array('User');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_login() {
		$this->layout = 'admin_login';

		Assert::true(User::isGuest(), '403');
		if ($this->isGet()) {
			$msg = "Good to see you again... But how come you are not logged in yet?!"; //@todo l18n use codes
			return $this->Message->add(__($msg, true), 'error');
		}

		$success = false;
		$login = false;
		$authId = $this->User->findIdByAuth($this->data['User']['login'], $this->data['User']['password']);

		if (Configure::read('Session.save') == 'model') {
			$userSession = $this->Session->SessionInstance->userSession(
				$authId, array('SessionInstance.key !=' => $this->Session->id()), true
			);

			if (!empty($authId) && (empty($userSession) || !empty($this->data['User']['login']))) {
				$login = true;
				if (!empty($userSession)) {
					$this->Session->SessionInstance->delete(
						$userSession['SessionInstance'][$this->Session->SessionInstance->primaryKey]
					);
				}
			}
		}

		if (!empty($authId)) {
			$login = true;
			$success = true;
		}

		if ($login && (empty($userSession) || !empty($this->data['User']['login']))) {
			$remember = isset($this->data['User']['remember']) 
							? (bool) $this->data['User']['remember']
							: false;

			User::login($authId, true, $remember);
			$this->Session->write('User.justLoggedIn', true);
		}

		if ($success) {
			return $this->redirect('/admin/home');
		}

		if (!empty($userSession) && !empty($authId)) {
			return $this->set('existingSession', true);
		}

		$msg = 'Sorry, but there is no activated user with these login credentials.'; //@todo l18n use codes
		$this->Message->add(__($msg, true), 'error');
		$this->set('invalidAccount', true);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function logout() {
		$name = User::name();
		User::logout();
		$this->Cookie->del('User');
		$this->redirect('/');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */	
	function admin_logout() {
		$name = User::name();
		User::logout();
		$this->Cookie->del('User');
		$this->redirect('/');
	}
}
?>