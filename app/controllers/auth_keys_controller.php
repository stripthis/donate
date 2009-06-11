<?php
class AuthKeysController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function view($key) {
		$userId = $this->params['named']['user_id'];
		$authKeyTypeId = $this->params['named']['auth_key_type_id'];

		Assert::true(Common::isUuid($userId), '403');
		Assert::true(Common::isUuid($authKeyTypeId), '403');
		Assert::true(AuthKey::verify($key, $userId, $authKeyTypeId), '403');
		$authKeyType = $this->AuthKey->AuthKeyType->lookup(array('id' => $authKeyTypeId), 'name', false);
		User::login($userId);

		switch ($authKeyType) {
			case 'Lost Password': {
				$this->Session->write('lost_password', true);
				$msg = 'Please go ahead and change your password now.';
				$this->Message->add($msg, 'ok', true, '/users/edit_password/'.$userId);
			}
		}
	}
}

?>