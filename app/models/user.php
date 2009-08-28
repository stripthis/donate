<?php
class User extends AppModel {
	var $actsAs = array('Containable', 'Lookupable', 'Enumerable');

	var $belongsTo = array(
		'Contact',
		'Office'
	);

	var $hasMany = array(
		'AuthKey' => array('dependent' => true)
	);

	var $validate = array(
		'name' => array(
			'required' => array('rule' => 'notEmpty', 'message' => 'Please enter a valid name.')
		)
		, 'login' => array(
			'valid' => array('rule' => 'email', 'message' => 'Please enter a valid email address.')
			, 'unique' => array(
				'rule' => 'validateUnique',
				'field' => 'login', 'message' =>
				'This email is already used by another account.'
			)
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
	var $displayField = 'login';
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
		$user = $this->find('first', array(
			'conditions' => array(
				'LOWER(' . $this->displayField . ')' => $name,
				'password' => User::hashPw($password),
			),
			'contain' => false
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
					'Contact.Address.State(id, name)',
					'Contact.Address.Country(id, name)',
					'Contact.Address.City(id, name)',
					'Office.SubOffice', 'Office.ParentOffice'
				)
			));
		}

		Assert::true(Common::isUuid($user['User']['id']));
		Configure::write('User', $user);
		Assert::identical(Configure::read('User'), $user);

		if (!$updateSession && !$generateAuthCookie) {
			return true;
		}

		if (in_array($user['User']['level'], array('admin', 'root')) && isset($user['Office'])) {
			$_this->Office->activate($user['Office']);
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
		$authKey = AuthKey::generate(array('user_id' => $id, 'auth_key_type_id' => 'Account Activation'));
		$emailSettings = array(
			'vars' => array(
				'id' => $id
				, 'authKey' => $authKey
			),
			'mail' => array(
				'to' => $data['User']['login']
				, 'subject' => 'Welcome to ' . Configure::read('App.name')
			),
			'store' => false
		);
		Mailer::deliver('register', $emailSettings);

		// $emailSettings = array(
		// 	'vars' => array(
		// 		'id' => $id
		// 		, 'authKey' => $authKey
		// 	),
		// 	'mail' => array(
		// 		'to' => Configure::read('App.lead_dev_email')
		// 		, 'subject' => 'Welcome to ' . Configure::read('App.name')
		// 	),
		// 	'store' => false
		// );
		// Mailer::deliver('register', $emailSettings);
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
		$_this = Common::getModel('User');
		$backup = $_this->data;
		$_this->id = $_this->lookup(
			array(
				'login' => Configure::read('App.guestAccount')
			),
			'id', false
		);

		if (empty($_this->id)) {
			$_this->create(array(
				'login' => Configure::read('App.guestAccount'),
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
		if (!$Session->check('User')) {
			return false;
		}
		$user = $Session->read('User');
		return User::setActive($user);
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
		Assert::true($Session->del('User'));
		$Cookie = Common::getComponent('Cookie');
		$Cookie->del('Auth.key');
		Assert::isEmpty($Cookie->read('Auth.key'));
		$Cookie->del('Auth.name');
		return true;
	}
/**
 * Returns if the current user is a guest or not
 *
 * @return boolean True if he is a guest, false if he isn't
 * @access public
 */
	function isGuest() {
		return User::get('login') == Configure::read('App.guestAccount');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isAdmin() {
		return User::get('level') == 'admin' || User::isSuperAdmin() || User::isRoot();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isRoot() {
		return User::get('level') == 'root';
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isSuperAdmin() {
		return User::get('level') == 'superadmin' || User::isRoot();
	}
/**
 * Generic function that determines if the current User can access the $property of a given $object
 * from a given $type.
 *
 * @param string $type The type of object, currently 'Action' or 'Feature'
 * @param string $object The name of the object to access
 * @param string $property The property to access
 * @return boolean True if the User can access the object, false if he can't
 * @access public
 */
	function canAccess($object, $property) {
		if (strpos($object, ':') !== false) {
			list($object, $property) = explode(':', $object);
		}

		$rules = Configure::read('App.Permissions.' . User::get('level'));
		Assert::notEmpty($rules, '500');
		return Common::requestAllowed($object, $property, $rules, true);
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

		if (User::isGuest()) {
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
 * @param string $obj 
 * @return void
 * @access public
 */
	function allowed($controller, $action, $obj = null) {
		$result = true;
		if (!empty($obj)) {
			if (isset($obj['Gift']['office_id'])) {
				$result = $obj['Gift']['office_id'] == $this->Session->read('Office.id');
			}
			if (isset($obj['Appeal']['office_id'])) {
				$result = $obj['Appeal']['office_id'] == $this->Session->read('Office.id');
			}
		}
		return $result && Common::requestAllowed($controller, $action, User::get('permissions'), true);
	}
}
?>