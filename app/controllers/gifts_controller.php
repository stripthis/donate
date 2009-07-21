<?php
class GiftsController extends AppController {
/**
 * undocumented function
 *
 * @return void
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Appeal = ClassRegistry::init('Appeal');
		$this->AuthKey = ClassRegistry::init('AuthKey');
		$this->AuthKeyType = $this->AuthKey->AuthKeyType;
		$this->Office = ClassRegistry::init('Office');
		$this->GatewayOffice = $this->Office->GatewayOffice;
		$this->Country = $this->Gift->Country;
		$this->Transaction = $this->Gift->Transaction;
	}
/**
 * undocumented function
 *
 * @param string $step 
 * @return void
 */
	function add($step = null) {
		$appealOptions = $this->Appeal->find('list');
		$countryOptions = $this->Country->find('list');
		$officeOptions = $this->Office->find('list');
		$this->set(compact('appealOptions', 'countryOptions', 'officeOptions'));

		if ($this->isGet()) {
			return;
		}


		$this->_reuseDataInCookie();

		$this->Gift->create($this->data);
		if (!$this->Gift->validates()) {
			$msg = 'Sorry, something went wrong processing your gift data. ';
			$msg .= 'Please correct the errors below.';
			return $this->Message->add($msg, 'error');
		}

		$this->Gift->save();
		$giftId = $this->Gift->getLastInsertId();
		$officeId = $this->data['Gift']['office_id'];

		//@todo dont always use the first one, make it dependent on the payment method
		$gateway = $this->GatewayOffice->find('first', array(
			'conditions' => array('office_id' => $officeId),
			'contain' => false
		));

		//@todo save payment data here?
		$this->Transaction->create(array(
			'gift_id' => $giftId,
			'amount' => $this->data['Gift']['amount'],
			'gateway_id' => $gateway['GatewayOffice']['gateway_id']
		));
		$this->Transaction->save();
		$tId = $this->Transaction->getLastInsertId();

		$result = $this->Transaction->process($tId);
		if ($result !== true) {
			$msg = 'There was a problem processing the transaction: ';
			$msg .= $result;
			// todo proper error msgs
			return $this->Message->add($msg);
		}

		App::import('Model', 'TimeZone');
		$userId = !User::isGuest() ? User::get('id') : $this->data['Gift']['email'];
		$authKeyTypeId = $this->AuthKeyType->lookup(array('name' => 'Transaction Receipt'), 'id', false);
		$authKey = AuthKey::generate(array(
			'user_id' => $userId
			, 'auth_key_type_id' => $authKeyTypeId
			, 'foreign_id' => $tId
			, 'expires' => TimeZone::date('Y-m-d H:i:s', 'UTC', '+3 days')
		));

		$this->_addAuthkeyToSession($userId, $authKey, $authKeyTypeId, $tId);

		// @todo maybe email the user the receipt

		$this->redirect(array('action' => 'thanks'));
	}
/**
 * undocumented function
 *
 * @param string $userId 
 * @param string $authKey 
 * @return void
 * @access public
 */
	function receipt($key, $tId) {
		$userId = $this->params['named']['user_id'];
		$authKeyTypeId = $this->params['named']['auth_key_type_id'];

		Assert::true(Common::isUuid($authKeyTypeId), '403');
		Assert::true(Common::isUuid($tId), '403');
		Assert::true(AuthKey::verify($key, $userId, $authKeyTypeId, $tId), '403');

		$transaction = $this->Transaction->find('first', array(
			'conditions' => array('Transaction.id' => $tId),
			'contain' => array('Gift.Country')
		));
		$this->set(compact('transaction'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function thanks() {
		
	}
/**
 * undocumented function
 *
 * @param string $authKey 
 * @return void
 * @access public
 */
	function _addAuthkeyToSession($userId, $authKey, $authKeyTypeId, $foreignId) {
		$sessKey = 'gift_auth_keys';
		$authKeys = $this->Session->read($sessKey);
		$authKeys[] = array(
			'user_id' => $userId,
			'key' => $authKey,
			'auth_key_type_id' => $authKeyTypeId,
			'foreign_id' => $foreignId
		);
		$this->Session->write($sessKey, $authKeys);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _reuseDataInCookie() {
		if (isset($this->data['Gift'])) {
			foreach ($this->data['Gift'] as $field => $value) {
				$this->Cookie->write($field, $value);
			}
		}
	}
}
?>