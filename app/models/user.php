<?php
class User extends AppModel {
	var $actsAs = array(
		'Containable',
		'Lookupable',
		'Enumerable',
		'SavedBy'
	);

	var $belongsTo = array(
		'Contact',
		'Office',
		'Role'
	);

	var $hasMany = array(
		'AuthKey' => array('dependent' => true),
		'ReportsUser' => array('dependent' => true)
	);

	var $validate = array(
		'name' => array(
			'required' => array('rule' => 'notEmpty', 'message' => 'Please enter a valid name.')
		)
		, 'login' => array(
			'valid' => array('rule' => 'email', 'message' => 'Please enter a valid email address.')
			// , 'unique' => array(
			// 	'rule' => 'validateUnique',
			// 	'field' => 'login', 'message' =>
			// 	'This email is already used by another account.'
			// )
		)
		, 'password' => array(
			'required' => array(
				'rule' => array('minLength', 5),
				'message' => 'Please enter a password that is at least 5 characters long.'
			)
			, 'confirmed' => array(
				'rule' => 'validateConfirmed',
				'confirm' => 'repeat_password',
				'message' => 'The two passwords were not identical.'
			)
		)
		, 'country_id' => array(
			'rule' => 'notEmpty', 'message' => 'Please insert a valid country.'
		)
	);
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $displayField = 'name';
/**
 * undocumented 
 *
 * @access public
 */
	function beforeSave() {
		if (isset($this->data[__CLASS__]['permissions']) && is_array($this->data[__CLASS__]['permissions'])) {
			$permissions = Configure::read('App.permissions.options');

			$perms = array();
			foreach ($this->data[__CLASS__]['permissions'] as $perm => $checked) {
				if ($checked) {
					$perms[] = $perm;
				}
			}

			if ($this->data[__CLASS__]['id'] && !class_exists('ShellDispatcher')) {
				Common::getComponent('Session')->logout($this->data[__CLASS__]['id']);
			}

			$diff = array_diff($permissions, $perms);
			if (empty($diff)) {
				$this->data[__CLASS__]['permissions'] = '';
			} else {
				$s = '';
				foreach ($diff as $perm) {
					$s .= '!' . $perm . ',';
				}
				$this->data[__CLASS__]['permissions'] = substr($s, 0, -1);
			}
		}

		if (isset($this->data[__CLASS__]['reports'])) {
			$this->ReportsUser->deleteAll(array('user_id' => $this->id));
			foreach ($this->data[__CLASS__]['reports'] as $reportId => $checked) {
				if (!$checked) {
					continue;
				}
				$this->ReportsUser->create(array(
					'user_id' => $this->id,
					'report_id' => $reportId
				));
				$this->ReportsUser->save();
			}
		}

		if (!isset($this->data[__CLASS__]['office_id'])) {
			$Session = Common::getComponent('Session');
			$this->data[__CLASS__]['office_id'] = $Session->read('Office.id');
		}
		if (isset($this->data[__CLASS__]['login'])) {
			$this->data['Contact']['email'] = $this->data[__CLASS__]['login'];
		}

		if (isset($this->data['Contact']['fname']) && isset($this->data['Contact']['lname'])) {
			$this->data[__CLASS__]['name'] = $this->data['Contact']['fname'] . ' ' . $this->data['Contact']['lname'];
		}
		
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function afterSave() {
		if (isset($this->data[__CLASS__]['public_key'])) {
			$Pgp = Common::getComponent('Pgp');
			$Pgp->import($this->data[__CLASS__]['public_key']);
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param unknown $user
 * @param unknown $password
 * @return void
 * @access public
 */
	function findIdByAuth($name, $password) {
		$name = low($name);
		$conditions = array(
			'LOWER(login)' => $name,
			'password' => User::hashPw($password),
		);
		$user = $this->find('first', array(
			'conditions' => $conditions
		));

		if (!empty($user)) {
			return $user['User']['id'];
		}

		return false;
	}

	/**
 * undocumented function
 *
 * @param string $row
 * @param string $action
 * @param string $urlParams
 * @return void
 * @access public
 */
	static function url($user, $action = 'person', $urlParams = array()) {
		$_this = ClassRegistry::init(__CLASS__);
		$urlParams['action'] = $action;
		return AppModel::url(__CLASS__, $user, $urlParams);
	}
/**
 * Generic function to access information of the User that is currently logged in.
 *
 * @param string $field The name of the key one wants to read
 * @param string $model Name of the associated $model to return information from (defaults to the User model itself)
 * @return mixed Either the value of $field on success or 'false' on failure
 * @access public
 */
	static function get($field = null) {
		$user = Configure::read('User');

		if (empty($user) && !defined('INTERNAL_CAKE_ERROR')) {
			User::sessionLogin() || User::cookieLogin() || User::guestLogin();
			$user = Configure::read('User');
			Assert::notEmpty($user);
		}

		if (empty($field) || is_null($user)) {
			return $user;
		}

		if (strpos($field, '.') === false) {
			if (in_array($field, array_keys($user))) {
				return $user[$field];
			}
			$field = 'User.'.$field;
		}

		return Set::extract($user, $field);
	}
/**
 * Uses a given $user data array to make him the active user
 *
 * @param array $user A User data array as returned by User::read()
 * @return boolean True on success, false on failure
 * @access public
 */
	static function setActive($user = null, $updateSession = false, $generateAuthCookie = false) {
		$_this = ClassRegistry::init('User');
		if (Common::isUuid($user)) {
			$user = $_this->find('first', array(
				'conditions' => array('User.id' => $user),
				'contain' => array(
					'Role(permissions, name)',
					'Contact.Address.State(id, name)',
					'Contact.Address.Country(id, name)',
					'Contact.Address.City(id, name)'
				),
				'fields' => array(
					'User.id', 'User.name', 'User.login', 'User.password', 'User.permissions',
					'User.active', 'User.tooltips', 'User.role_id', 'User.office_id',
					'User.contact_id'
				)
			));
		}

		Assert::true(Common::isUuid($user['User']['id']), '500');
		Configure::write('User', $user);
		Assert::identical(Configure::read('User'), $user);

		if (!$updateSession && !$generateAuthCookie) {
			return true;
		}

		if (!User::is('guest') && isset($user['User']['office_id'])) {
			$_this->Office->activate($user['User']['office_id']);
		}

		$Session = Common::getComponent('Session');
		Assert::true($Session->write('User', $user));

		$Cookie = Common::getComponent('Cookie');
		$Cookie->write('Auth.name', $user['User']['login'], false, Configure::read('App.loginCookieLife'));

		// if ($user['User']['login'] != Configure::read('App.guestAccount')) {
		// 	$oldDomain = $Cookie->domain;
		// 	$Cookie->domain = '.greenpeace.org';
		// 	$Cookie->write('User.name', $user['User']['name'], false, Configure::read('App.loginCookieLife'));
		// 	$Cookie->write('User.country', $user['Address']['Country']['name'], false, Configure::read('App.loginCookieLife'));
		// 	$Cookie->domain = $oldDomain;
		// }

		if (!$generateAuthCookie) {
			return true;
		}
		$key = AuthKey::generate(array('auth_key_type_id' => 'Login Cookie'));

		$Cookie->write('Auth.key', $key, true, Configure::read('App.loginCookieLife'));
		return Assert::equal($Cookie->read('Auth.key'), $key);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function activationEmail($id, $data) {
		$authKey = AuthKey::generate(array(
			'user_id' => $id,
			'auth_key_type_id' => 'Account Activation'
		));
		$emailSettings = array(
			'vars' => array(
				'id' => $id
				, 'authKey' => $authKey
			),
			'mail' => array(
				'to' => $data['User']['login']
				, 'subject' => sprintf(__('Welcome to %s', true), Configure::read('App.name'))
			),
			'store' => false
		);
		Mailer::deliver('register', $emailSettings);
	}
/**
 * undocumented function
 *
 * @param string $userId 
 * @return void
 * @access public
 */
	function referral_key($userId, $forceCreate = false) {
		App::import('Core', 'Security');
		if (!$forceCreate) {
			$key = $this->lookup(array('id' => $userId), 'referral_key', false);
			if (!empty($key)) {
				return $key;
			}
		}

		do {
			$key = Security::generateAuthKey();
			$key = substr($key, 0, 10);
		} while (!$this->isUnique(array('referral_key' => $key)));

		$this->set(array(
			'id' => $userId,
			'referral_key' => $key
		));
		$this->save();
		return $key;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function restore() {
		return User::setActive(User::get('id'), true);
	}
/**
 * undocumented function
 *
 * @param unknown $user
 * @param unknown $log
 * @return void
 * @access public
 */
	static function login($user, $permantly = false) {
		Assert::true(User::setActive($user, true, $permantly));
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function guestLogin() {
		$_this = ClassRegistry::init(__CLASS__);
		$backup = $_this->data;
		$_this->id = $_this->lookup(
			array('login' => Configure::read('App.emails.guestAccount')),
			'id', false
		);

		if (empty($_this->id)) {
			$_this->create(array(
				'login' => Configure::read('App.emails.guestAccount'),
				'level' => 'guest'
			));
			Assert::notEmpty($_this->save(), 'no_guest_account');
		}

		User::setActive($_this->id, true);
		$_this->set($backup);
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function cookieLogin() {
		$Cookie = Common::getComponent('Cookie');
		$key = $Cookie->read('Auth.key');
		if (empty($key)) {
			return false;
		}
		$userId = AuthKey::findUserId($key, 'Login Cookie');
		if (empty($userId)) {
			return false;
		}
		return User::login($userId, true);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function sessionLogin() {
		$Session = Common::getComponent('Session');
		$user = $Session->read('User');
		if (!$user) {
			return false;
		}
		return User::setActive($user['User']['id']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function logout() {
		Configure::delete('User');
		Assert::isNull(Configure::read('User'));
 		$Session = Common::getComponent('Session');
		$Session->del('User');
		$Cookie = Common::getComponent('Cookie');
		$Cookie->del('Auth.key');
		Assert::isEmpty($Cookie->read('Auth.key'));
		$Cookie->del('Auth.name');
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function hashPw($pw) {
		return Security::hash(Configure::read('Security.salt').$pw);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function ip() {
		$RequestHandler = Common::getComponent('RequestHandler');
		return $RequestHandler->getClientIP();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function agent() {
		return env('HTTP_USER_AGENT');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function name() {
		return User::get('User.login');
	}
/**
 * undocumented function
 *
 * @param string $record
 * @param string $options
 * @return void
 * @access public
 */
	static function canEdit($record, $options = array()) {
		if (is_string($options)) {
			$options = array('model' => $options);
		}
		if (!isset($options['model'])) {
			$options['model'] = key($record);
		}
		if (method_exists($options['model'], 'canEdit')) {
			return call_user_func(array($options['model'], 'canEdit'), $record, $options);
		}

		if (User::is('guest')) {
			return false;
		}

		if (!isset($record[$options['model']]['user_id'])) {
			return false;
		}
		return $record[$options['model']]['user_id'] == User::get('id');
	}
/**
 * Get gravatar url or default user picture
 * @scope static 
 */
	static function gravatarUrl($user) {
		$user = AppModel::normalize('User', $user);
		$param = "?&rating=G";
		$param .= "&size=".Configure::read('App.avatarSize');;
		//$param.= "&default=".Configure::read('App.domain').Configure::read('Avatar.avatarDefault');
		return ($user)
			? sprintf('http://www.gravatar.com/avatar/%s.jpg', md5(strtolower($user['User']['login']))).$param
			: false;
	}
/**
 * undocumented function
 *
 * @param string $obj 
 * @return void
 * @access public
 */
	function allowed($controller, $action, $obj = null) {
		if (User::is('root')) {
			return true;
		}

		$result = true;
		if (!empty($obj)) {
			if (isset($obj['Gift']['office_id'])) {
				$result = $obj['Gift']['office_id'] == $this->Session->read('Office.id');
			}
			if (isset($obj['Appeal']['office_id'])) {
				$result = $obj['Appeal']['office_id'] == $this->Session->read('Office.id');
			}
			if (isset($obj['User']['office_id'])) {
				$result = $obj['User']['office_id'] == $this->Session->read('Office.id');
			}
		}

		$result = $result && Common::requestAllowed($controller, $action, User::get('Role.permissions'), true);
		return $result && Common::requestAllowed($controller, $action, User::get('permissions'), true);
	}
/**
 * Returns if the current user is a guest or not
 *
 * @return boolean True if he is a guest, false if he isn't
 * @access public
 */
	function is($role) {
		if ($role == 'guest') {
			return User::get('login') == Configure::read('App.emails.guestAccount');
		}
		return User::get('Role.name') == $role;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function savePassword() {
		$pwData = $this->generatePassword();
		$password = $pwData[0];
		$this->set(array(
			'id' => $this->id,
			'password' => $pwData[1]
		));
		$this->save(null, false);
		return $password;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function generatePassword() {
		$pw = substr(md5(microtime()), 0, 9);
		return array($pw, User::hashPw($pw));
	}
/**
 * undocumented function
 *
 * @param string $data 
 * @param string $password 
 * @return void
 * @access public
 */
	function sendNewAccountEmail($password, $data) {
		$options = array(
			'mail' => array(
				'to' => $data['User']['login'],
				'subject' => __('New Account for Greenpeace White Rabbit', true)
			),
			'vars' => array(
				'url' => Configure::read('App.domain'),
				'password' => $password
			)
		);
		Mailer::deliver('created_admin', $options);

		$managers = $this->find('office_managers', array(
			'exclude_me' => true,
			'office_id' => $data[__CLASS__]['office_id']
		));

		foreach ($managers as $manager) {
			$options = array(
				'mail' => array(
					'to' => $manager[__CLASS__]['login'],
					'subject' => __('New Admin created in your office for Greenpeace White Rabbit', true)
				),
				'vars' => array(
					'url' => Configure::read('App.domain'),
					'login' => $data[__CLASS__]['login'],
					'creator' => User::get()
				)
			);
			Mailer::deliver('office_admin_note_for_new_user', $options);
		}
	}
/**
 * undocumented function
 *
 * @param string 
 * @param string 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'office_managers':
				$roleId = $this->Role->lookup('office_manager', 'id', false);
				$conditions = array(
					'role_id' => $roleId
				);
				if (isset($query['office_id'])) {
					$conditions['office_id'] = $query['office_id'];
				}
				if (isset($query['exclude_me']) && $query['exclude_me']) {
					$conditions['id <>'] = User::get('id');
				}
				$fields = isset($query['fields'])
							? $query['fields']
							: array('id', 'login');
				return $this->find('all', array(
					'conditions' => $conditions,
					'fields' => $fields
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>