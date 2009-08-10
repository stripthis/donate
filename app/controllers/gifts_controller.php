<?php
class GiftsController extends AppController {
	var $helpers = array('Fpdf');
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
		$this->Contact = $this->Gift->Contact;
		$this->Country = $this->Gift->Contact->Country;
		$this->Transaction = $this->Gift->Transaction;
	}
	
/**
 * Add a Gift - Catch All!
 */
	function add($appealIdentifier = null, $step = null) {
		$appealOptions = $this->Appeal->find('list'); 
		$countryOptions = $this->Country->find('list');
		$officeOptions = $this->Office->find('list');

		// try to find the requested appeal or the default one
		$currentAppeal = $this->Appeal->getAppeal($appealIdentifier);
		if(!isset($currentAppeal)){
			//@todo no appeal in db => empty page + warning in admin space
		} else {
			$this->data["Gift"]["appeal_id"] = $currentAppeal["Appeal"]["id"];
			$this->viewPath = "templates" . DS . $currentAppeal["Appeal"]["id"];
			$officeId = $currentAppeal['Appeal']['office_id'];
		}
		$this->set(compact('appealOptions', 'countryOptions', 'officeOptions','currentAppeal'));
		
		// no data was given so we render the selected/default view
		if ($this->isGet()) {
			return;
		}
		
		// Some data was given, we try to save
		$this->_reuseDataInCookie();
		
		// try to validate and save contact data
		if (isset($this->data['Contact'])) {
			if (isset($this->data['Contact']['id'])) {
				$contactFound = $this->Contact->find('first', array(
					'conditions' => array('id' => $this->data['Contact']['id'],
					'contain' => false
				)));
				if (!isset($contactFound)) {
		  			$errorStep[] = 'Contact';
				} else {
					$contactId = $this->data['Gift']['contact_id'] = $this->data['Contact']['id'];
				}
			} else {
				//@todo city validation & save
				$this->Contact->create($this->data);
				if ($this->Contact->validates()) {
					$this->Contact->save();
					// update gift relationship with contact
					$contactId = $this->data['Gift']['contact_id'] = $this->Contact->getLastInsertId();
				} else {
					$errorStep[] = 'Contact';
				}
			}
		}
		
		// try to save gift data
		if (isset($this->data['Gift'])) {
			// radio + textfield mode (cf. other)
			if (isset($this->data['Gift']['amount']) && $this->data['Gift']['amount'] == "other" 
				&& isset($this->data['Gift']['amount_other'])) {
				$this->data['Gift']['amount'] = $this->data['Gift']['amount_other'];
			}
			$this->Gift->create($this->data);
			if ($this->Gift->validates()) {
				$this->Gift->save();
				$giftId = $this->data['Gift']['id'] = $this->Gift->getLastInsertId();
			} else {
				$errorStep[] = 'Gift';
			}
		}

		if (isset($errorStep) && count($errorStep)) {
			$msg = 'Sorry, something went wrong, please correct the errors below.';
			return $this->Message->add(__($msg, true), 'error');
		}
		
		// everything ok prepare / perform the transaction
		//@todo dont always use the first one, make it dependent on the payment method 
		//@todo && the amount / currency vs. payment gateway fee by offices
		$gateway = $this->GatewayOffice->find('first', array(
			'conditions' => array('office_id' => $officeId,
			'contain' => false
		)));

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
			$msg = 'There was a problem processing the transaction: ' . $result;
			return $this->Message->add(__($msg, true));
		}

		$keyData = $this->_addAuthkeyToSession($tId);
		$this->Gift->emailReceipt($this->data['Gift']['email'], $keyData);

		$this->redirect(array('action' => 'thanks'));
	}

/**
 * undocumented function
 *
 * @param $appealCode id, name or campaign_code
 * @param string $step 
 * @return void
 */
	function add_v1($appealIdentifier = null, $step = null) {
		$appealOptions = $this->Appeal->find('list');
		$countryOptions = $this->Country->find('list');
		$officeOptions = $this->Office->find('list');
		
		// try to find the requested appeal or the default one
		$currentAppeal = $this->Appeal->getAppeal($appealIdentifier);
		if($currentAppeal == null){
			//@todo no appeal in db => empty page + warning in admin space
		} else {
			$this->viewPath = "templates" . DS . $currentAppeal["Appeal"]["id"];
		}
		$this->set(compact('appealOptions', 'countryOptions', 'officeOptions','currentAppeal'));
		
		// no data was given so we render the selected/default view
		if ($this->isGet()) {
			return;
		}

		//Some data where given, we try to save
		$this->_reuseDataInCookie();
				
		/* gift */
		$this->Gift->create($this->data);
		if (!$this->Gift->validates()) {
			$msg = 'Sorry, something went wrong processing your gift data. ';
			$msg .= 'Please correct the errors below.';
			return $this->Message->add(__($msg, true), 'error');
		}

		$this->Gift->save();
		$giftId = $this->Gift->getLastInsertId();
		$officeId = $this->data['Gift']['office_id'];

		//@todo dont always use the first one, make it dependent on the payment method 
		//@todo make it also dependent of the amount / payment gateway fee
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
			return $this->Message->add(__($msg, true));
		}

		$keyData = $this->_addAuthkeyToSession($tId);
		$this->Gift->emailReceipt($this->data['Gift']['email'], $keyData);

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
 * @return void
 * @access public
 */
	function admin_index() {
		$keyword = isset($this->params['url']['keyword'])
					? $this->params['url']['keyword']
					: '';
		$type = isset($this->params['url']['type'])
					? $this->params['url']['type']
					: 'person';

		$conditions = array();
		if (!empty($keyword)) {
			$keyword = trim($keyword);
			switch ($type) {
				case 'gift':
					$conditions['Gift.id LIKE'] = '%' . $keyword . '%';
					break;
				case 'appeal':
					$conditions['Appeal.name LIKE'] = '%' . $keyword . '%';
					break;
				case 'office':
					$conditions['Office.name LIKE'] = '%' . $keyword . '%';
					break;
				default:
					$key = "CONCAT(Gift.fname,' ',Gift.lname)";
					$conditions[$key . ' LIKE'] = '%' . $keyword . '%';
					break;
			}
		}

		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'contain' => array(
				'Country(name)', 'Office(id, name)', 'Appeal(id, name)'
			),
			'limit' => 20
		);
		$gifts = $this->paginate();
		$this->set(compact('gifts', 'keyword', 'type'));
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
		$gift = $this->Gift->find('first', array(
			'conditions' => array('Gift.id' => $id),
			'contain' => array(
				'Country(name)', 'Office(id, name)', 'Appeal(id, name)',
				'Comment(id, created, body, user_id)' => 'User(login, id)' 
			)
		));
		$this->set(compact('gift'));
	}
/**
 * undocumented function
 *
 * @param string $authKey 
 * @return void
 * @access public
 */
	function _addAuthkeyToSession($tId) {
		App::import('Model', 'TimeZone');
		$userId = !User::isGuest() ? User::get('id') : $this->data['Gift']['email'];
		$authKeyTypeId = $this->AuthKeyType->lookup(array('name' => 'Transaction Receipt'), 'id', false);
		$authKey = AuthKey::generate(array(
			'user_id' => $userId
			, 'auth_key_type_id' => $authKeyTypeId
			, 'foreign_id' => $tId
			, 'expires' => TimeZone::date('Y-m-d H:i:s', 'UTC', '+3 days')
		));
		$keyData = array(
			'user_id' => $userId,
			'key' => $authKey,
			'auth_key_type_id' => $authKeyTypeId,
			'foreign_id' => $tId
		);

		$sessKey = 'gift_auth_keys';
		$authKeys = $this->Session->read($sessKey);
		$authKeys[] = $keyData;
		$this->Session->write($sessKey, $authKeys);

		return $keyData;
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