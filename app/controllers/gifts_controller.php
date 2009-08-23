<?php
class GiftsController extends AppController {
	var $helpers = array('Fpdf', 'GiftForm');
	var $models = array('Gift', 'Contact', 'Address', 'Phone');
	var $sessOfficeKey = 'gift_process_office_id';
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
		$this->GatewaysOffice = $this->Office->GatewaysOffice;
		$this->Contact = $this->Gift->Contact;
		$this->Country = $this->Gift->Contact->Address->Country;
		$this->City = $this->Gift->Contact->Address->City;
		$this->Transaction = $this->Gift->Transaction;
		$this->Card = ClassRegistry::init('Card');
	}
/**
 * Add a catch
 *
 * @param string $appealId 
 * @param string $step 
 * @return void
 * @access public
 */
	function add($step = 1) {
		$this->checkForValidOfficeId($step);
		$officeId = $this->Session->read($this->sessOfficeKey);

		$currentAppeal = $this->Appeal->find('by_office', array(
			'office_id' => $officeId
		));
		Assert::notEmpty($currentAppeal, '500');

		$this->data['Gift']['appeal_id'] = $currentAppeal['Appeal']['id'];
		$this->viewPath = 'templates' . DS . $currentAppeal['Appeal']['id'];

		$countryOptions = $this->Country->find('list');
		$this->set(compact('countryOptions', 'currentAppeal'));

		// no data was given so we render the selected/default view
		if ($this->isGet()) {
			return $this->render('step' . $step);
		}

		$this->loadSessionData($this->data);

		$this->City->injectCityId($this->data);
		if (!empty($this->data['Gift']['amount_other'])) {
			$this->data['Gift']['amount'] = $this->data['Gift']['amount_other'];
		} elseif (isset($this->data['Gift']['amount']) && $this->data['Gift']['amount'] == 'other') {
			$this->data['Gift']['amount'] = '';
			$this->data['Gift']['amount_other'] = '';
		}

		$isLastStep = $step == $currentAppeal['Appeal']['steps'];
		$validates = AppModel::bulkValidate($this->models, $this->data);

		if (!$isLastStep && !$validates) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			return $this->render('step' . $step);
		}

		if (!$isLastStep && $validates) {
			$this->saveSessionData();
			return $this->render('step' . ($step + 1));
		}

		// for the last step, reset is_required to required to prevent hacking attemps
		$validates = AppModel::bulkValidate($this->models, $this->data, true);
		if (!$validates) {
			$msg = 'There are problems with the form. This is a possible hacking attempt.';
			$this->Message->add($msg, 'error');
			return $this->render('step' . $step);
		}
		$this->saveSessionData();

		// save data with transactions
		$db = ConnectionManager::getDataSource('default');
		$db->begin($this->Gift);
		$errors = false;

		$contactId = false;
		if (isset($this->data['Contact'])) {
			$contactId = $this->Contact->addFromGift($this->data, false);
		}
		if (!Common::isUuid($contactId)) {
			$errors = true;
		}

		if (!$errors) {
			$this->data['Gift']['contact_id'] = $contactId;
			$this->data['Gift']['office_id'] = $officeId;
			unset($this->data['Gift']['id']);

			$this->Gift->create($this->data);
			if ($this->Gift->save()) {
				$giftId = $this->data['Gift']['id'] = $this->Gift->getLastInsertId();
			} else {
				$errors = true;
			}
		}

		// credit card data is given
		// @todo if appeal or payment gateway use redirect model then redirect
		// else if the credit data is given, validates
		if (isset($this->data['Card']) && $currentAppeal['Appeal']['processing'] == 'manual') {
			$this->Card->set($this->data);
			if ($this->Card->validates()) {
				//@todo if application used in manual/direct debit mode, save credit card details
				//But for now: *WE DON'T SAVE*
			} else {
				$errors = true;
			}
		}

		if ($errors) {
			$db->rollback($this->Gift);
			$msg = 'Sorry, something went wrong, please correct the errors below.';
			$this->Message->add(__($msg, true), 'error');
			return $this->render('step' . $step);
		}

		$db->commit($this->Gift);

		// everything ok prepare / perform the transaction
		//@todo dont always use the first one, make it dependent on the payment method 
		//@todo && the amount / currency vs. payment gateway fee by offices
		$gateway = $this->GatewaysOffice->find('by_office', array(
			'office_id' => $officeId
		));

		//@todo save payment data here?
		$this->Transaction->create(array(
			'gift_id' => $giftId,
			'amount' => $this->data['Gift']['amount'],
			'gateway_id' => $gateway['GatewaysOffice']['gateway_id']
		));
		$this->Transaction->save();
		$tId = $this->Transaction->getLastInsertId();

		$result = $this->Transaction->process($tId);
		if ($result !== true) {
			$msg = 'There was a problem processing the transaction: ' . $result;
			$this->Message->add(__($msg, true));
			return $this->render('step' . $step);
		}

		$keyData = $this->_addAuthkeyToSession($tId);
		$this->Gift->emailReceipt($this->data['Contact']['email'], $keyData);

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
			'contain' => array(
				'Gift.Contact.Address.Phone', 'Gift.Contact.Phone'
			)
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
					$key = "CONCAT(Contact.fname,' ',Contact.lname)";
					$conditions[$key . ' LIKE'] = '%' . $keyword . '%';
					break;
			}
		}

		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'contain' => array(
				'Contact(fname, lname, email)', 'Office(id, name)', 'Appeal(id, name)'
			),
			'limit' => 20,
			'order' => array('Gift.created' => 'desc')
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
		$this->Gift->delete($id);
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
				'Contact.Address.Phone', 'Contact.Address.Country(id, name)',
				'Contact.Address.State(id, name)', 'Contact.Address.City(id, name)',
				'Office(id, name)', 'Appeal',
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
		$userId = !User::isGuest() ? User::get('id') : $this->data['Contact']['email'];
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
	function loadSessionData($formData) {
		foreach ($this->models as $model) {
			if (!$this->Session->check($model)) {
				continue;
			}
			if (!isset($this->data[$model])) {
				$this->data[$model] = array();
			}
			$this->data[$model] = am($this->Session->read($model), $this->data[$model]);
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function saveSessionData() {
		foreach ($this->models as $model) {
			if (!isset($this->data[$model])) {
				continue;
			}
			foreach ($this->data[$model] as $field => $value) {
				$this->Cookie->write($model . '.' . $field, $value);
				$this->Session->write($model . '.' . $field, $value);
			}
		}

		if (isset($this->data['Address']['country_id'])) {
			$countryName = $this->Country->lookup(array(
				'name' => $this->data['Address']['country_id']
			), 'id', false);
			$this->Cookie->write('Address.country_name', $countryName);
			$this->Session->write('Address.country_name', $countryName);
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function dropSessionData() {
		foreach ($this->models as $model) {
			$this->Session->del($model);
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function checkForValidOfficeId($step) {
		$msg = __('Please choose a country first!', true);

		if ($step == 1 && $this->isGet() && !isset($this->params['named']['office_id'])) {
			return $this->Message->add($msg, 'error', true, '/');
		}

		if (isset($this->params['named']['office_id'])) {
			$existingOffice = $this->Office->lookup(
				array('id' => $this->params['named']['office_id']),
				'id', false
			);
			$sessOfficeId = $this->Session->read($this->sessOfficeKey);
			if (!$existingOffice || $step != 1 && $sessOfficeId != $existingOffice) {
				return $this->Message->add($msg, 'error', true, '/');
			}

			$this->Session->write($this->sessOfficeKey, $this->params['named']['office_id']);
		}
	}
}
?>