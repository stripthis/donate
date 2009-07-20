<?php
class AuthKey extends AppModel{
	var $belongsTo = array('User', 'AuthKeyType');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function generate($key = array(), $autoRefresh = true) {
		if (Common::isUuid($key)) {
			$key = array('user_id' => $key);
		} elseif (!isset($key['user_id'])) {
			$key['user_id'] = User::get('id');
		}
		Assert::true(Common::isUuid($key['user_id']));

		$_this = Common::getModel('AuthKey');
		if (!Common::isUuid($key['auth_key_type_id']) && !empty($key['auth_key_type_id'])) {
			$key['auth_key_type_id'] = $_this->AuthKeyType->lookup($key['auth_key_type_id']);
		}
		Assert::true(Common::isUuid($key['auth_key_type_id']));

		$recursive = -1;
		$sameTypeKey = $_this->find('first', array(
			'conditions' => array(
				'user_id' => $key['user_id'],
				'auth_key_type_id' => $key['auth_key_type_id']
			),
			'recursive' => -1
		));
		if ($sameTypeKey) {
			if (!$autoRefresh) {
				return false;
			}
			$key['id'] = $sameTypeKey['AuthKey']['id'];
		}

		do {
			$key['key'] = Security::generateAuthKey();
		} while (!$_this->isUnique(array('key' => $key['key'])));

		Assert::notEmpty($key['key']);

		$_this->create();
		Assert::notEmpty($_this->save($key));
		return $key['key'];
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function purgeExpired($force = false) {
		static $purged = false;
		if (!$force && $purged == true) {
			return true;
		}
		$_this = Common::getModel('AuthKey');

		$conditions = array(
			'AuthKey.expires IS NOT NULL'
			, array('AuthKey.expires' => '<='.date('Y-m-d H:i:s'))
		);
		$_this->deleteAll($conditions);
		return $purged = true;
	}
/**
 * undocumented function
 *
 * @param unknown $key 
 * @return void
 * @access public
 */
	static function expire($key) {
		$_this = Common::getModel('AuthKey');
		return Assert::true($_this->deleteAll(compact('key')), false);
	}
/**
 * undocumented function
 *
 * @param unknown $key 
 * @param unknown $userId 
 * @return void
 * @access public
 */
	static function verify($key, $user_id, $auth_key_type_id, $foreign_id = null) {
		$_this = Common::getModel('AuthKey');
		AuthKey::purgeExpired();

		if (!Common::isUuid($auth_key_type_id)) {
			$auth_key_type_id = $_this->AuthKeyType->lookup($auth_key_type_id, 'id', false);
		}
		if (!Common::isUuid($auth_key_type_id)) {
			return false;
		}

		$options = compact('key', 'user_id', 'auth_key_type_id');
		if (!empty($foreign_id)) {
			$options = compact('key', 'user_id', 'auth_key_type_id', 'foreign_id');
		}
		return $_this->hasAny($options);
	}
/**
 * undocumented function
 *
 * @param unknown $key 
 * @param unknown $auth_key_type_id 
 * @return void
 * @access public
 */
	static function findUserId($key, $auth_key_type_id = null) {
		$_this = Common::getModel('AuthKey');
		if (!empty($auth_key_type_id) && !ctype_digit($auth_key_type_id)) {
			$auth_key_type_id = $_this->AuthKeyType->lookup($auth_key_type_id, 'id', false);
		}
		if (!empty($auth_key_type_id) && !ctype_digit($auth_key_type_id)) {
			return false;
		}

		$conditions = compact('key');
		$recursive = -1;
		if (!empty($auth_key_type_id)) {
			$conditions['auth_key_type_id'] = $auth_key_type_id;
		}
		$authKey = $_this->find('first', compact('conditions', 'recursive'));
		if (empty($authKey)) {
			return false;
		}
		return $authKey['AuthKey']['user_id'];
	}
/**
 * undocumented function
 *
 * @param unknown $oldKey 
 * @return void
 * @access public
 */
	static function renew($oldKey) {
		
	}
}

?>