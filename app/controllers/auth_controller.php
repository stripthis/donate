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

		if (!User::is('guest')) {
			$msg = __('You are logged in already!', true);
			return $this->Message->add($msg, 'error', true, Router::url('/admin/home'));
		}

		if ($this->isGet()) {
			return;
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
			$this->Session->del('cant_access');
			$this->Session->del('just_logged_out');
			$this->Session->write('User.justLoggedIn', true);
		}

		if ($success) {
			return $this->redirect('/admin/home');
		}

		if (!empty($userSession) && !empty($authId)) {
			return $this->set('existingSession', true);
		}

		$msg = __('Sorry, but there is no activated user with these login credentials.', true);
		$this->Message->add($msg, 'error');
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
		$this->Session->write('just_logged_out', true);
		$this->redirect('/');
	}
}
?>