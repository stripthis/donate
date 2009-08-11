<?php
/**
 * Create or  reset admin account
 * usage: cake/console/cake root username
 *
 */
App::import('Core', 'Security');

class AdminShell extends Shell {
	var $uses = array('User', 'Office', 'Contact');
	var $components = array('Security');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$login = isset($this->args[0]) ? $this->args[0] : false;

		if (empty($login) || $login == Configure::read('App.guestAccount')) {
			$this->out('Funny man ..');
			exit(1);
		}

		$data = $this->User->find('first', array(
			'conditions' => compact('login'),
			'contain' => false
		));

		if (!$data) {
			$this->out('The user ' . $login . ' does not exist yet. Please choose an office for this user:');
			$this->hr();
			$this->out('Office for the new User:');
			$officeOptions = $this->Office->find('list');
			$ids = array_keys($officeOptions);
			$names = array_values($officeOptions);

			foreach ($names as $i => $name) {
				$i++;
				$this->out($i . '. ' . $name);
			}

			$validChoice = false;
			do {
				$choice = $this->in('Please choose a number: ');
				if ($choice > count($officeOptions)) {
					$this->out('This number is not valid, please retry.');
				} else {
					$validChoice = true;
				}
			} while (!$validChoice);

			$data['User']['office_id'] = $ids[$choice - 1];
			$this->hr();

			$this->out('Salutation for the new user:');
			while (empty($data['Contact']['salutation'])) {
				$title = strtoupper($this->in('[M]r oder [Mr]s'));
				switch ($title) {
					case 'M':
						$data['Contact']['salutation'] = 'mr';
						break;
					case 'Mr':
						$data['Contact']['salutation'] = 'mrs';
						break;
					default:
						$this->out('Your input is invalid. Please type in either [M] or [Mr].', true);
				}
			}

			// @todo maybe add support for title (prof., dr., prof. dr., etc.)
			$data['Contact']['email'] = $login;

			while (true) {
				$data['Contact']['fname'] = $this->in('First Name:');
				$data['Contact']['lname'] = $this->in('Last Name:');
				if ($this->validates($data, 'Contact')) {
					break;
				}
			}
			$data['User']['name'] = $data['Contact']['fname'] . ' ' . $data['Contact']['lname'];
			$this->hr();


			$data['User']['level'] = 'admin';
			$data['User']['login'] = $login;

			$this->Contact->create($data);
			if (!$this->Contact->save()) {
				return $this->out('Sorry, an error has occurred while saving the contact data');
			}
			$contactId = $this->Contact->getLastInsertId();
			$data['User']['active'] = '1';
			$data['User']['contact_id'] = $contactId;

			$this->User->create();
		} else {
			$this->out('The user ' . $login . ' exists. Are you sure you want to reset the password for this user?');

			while (empty($confirm)) { 
				$confirm = strtoupper($this->in('[Y]es or [N]o'));
				switch ($confirm) {
					case 'Y':
						break;
					case 'N':
						$this->out('O.K. The script is terminated.');
						exit(0);
						break;
					default:
						$confirm = '';
						$this->out('Your input is invalid, please type in either [Y] or [N].', true);
				}
			}
		}
		$this->hr();

		$pwData = $this->User->generatePassword();
		$password = $pwData[0];
		$data['User']['password'] = $pwData[1];
		$data['User']['repeat_password'] = $pwData[1];

		if (!$this->User->save($data)) {
			pr($this->User->validationErrors);
			return $this->out('Sorry, an error has occurred while saving the user data.');
		}

		$msg = 'The admin account for ' . $login . ' has been created/reset successfully. ';
		$msg = 'An email has been sent to the email address.';

		// @todo email sending

		$this->out($msg);
		$this->out('password is: ' . $password);
	}
/**
 * undocumented function
 *
 * @param string $data 
 * @param string $model 
 * @param string $attribute 
 * @return void
 * @access public
 */
	function validates(&$data, $model) {
		$this->{$model}->set($data[$model]);
		if (!$this->{$model}->validates() ) {
			$this->out('Your input could not be validated, please retry.');
			return false;
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function help() {
		$this->out('Here comes the help message');
	}
}

?>