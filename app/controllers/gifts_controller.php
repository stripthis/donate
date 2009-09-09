<?php
class GiftsController extends AppController {
	var $helpers = array('Fpdf', 'GiftForm');
	var $components = array('GridFilter');
	var $models = array('Gift', 'Contact', 'Address', 'Phone');
	var $sessAppealKey = 'gift_process_appeal_id';
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
		$this->AppealStep = $this->Appeal->AppealStep;
		$this->GatewaysOffice = $this->Office->GatewaysOffice;
		$this->Contact = $this->Gift->Contact;
		$this->Address = $this->Contact->Address;
		$this->Phone = $this->Address->Phone;
		$this->Country = $this->Address->Country;
		$this->City = $this->Address->City;
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
		$this->checkForValidAppealId($step);

		$appealId = $this->Session->read($this->sessAppealKey);
		$currentAppeal = $this->Appeal->find('default', array('id' => $appealId));

		if (!$currentAppeal['Office']['live']) {
			return $this->redirect($currentAppeal['Office']['external_url']);
		}

		Assert::notEmpty($currentAppeal, '500');
		$officeId = $currentAppeal['Appeal']['office_id'];
		$this->Session->write($this->sessOfficeKey, $officeId);

		$this->data['Gift']['appeal_id'] = $currentAppeal['Appeal']['id'];
		$this->viewPath = 'templates' . DS . $currentAppeal['Appeal']['campaign_code'] . '_' . $currentAppeal['Appeal']['id'];

		$countryOptions = $this->Country->find('list', array('order' => array('Country.name' => 'asc')));
		$this->set(compact('countryOptions', 'currentAppeal'));

		$this->AppealStep->addVisit($appealId, $step);

		// no data was given so we render the selected/default view
		if ($this->isGet()) {
			if (!file_exists(VIEWS . $this->viewPath . DS . 'step' . $step . '.ctp')) {
				return;
			}
			return $this->render('step' . $step);
		}

		$this->loadSessionData($this->data);
		$this->City->injectCityId($this->data);

		if (!isset($this->data['Gift']['id']) || empty($this->data['Gift']['id'])) {
			$data = array(
				'complete' => 0,
				'office_id' => $officeId
			);
			if (!User::isGuest()) {
				$data['user_id'] = User::get('id');
			}
			$this->Gift->create($data);
			$this->Gift->save(null, false);
			$this->data['Gift']['id'] = $this->Gift->getLastInsertId();
		}

		if (isset($this->data['Gift']['amount_other']) && !empty($this->data['Gift']['amount_other'])) {
			$this->data['Gift']['amount'] = $this->data['Gift']['amount_other'];
		}

		$isLastStep = $step == $currentAppeal['Appeal']['appeal_step_count'];
		$validates = AppModel::bulkValidate($this->models, $this->data);

		if (!$isLastStep && !$validates) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			return $this->render('step' . $step);
		}

		if (!$isLastStep && $validates) {
			$this->saveRelatedData();
			$this->saveSessionData();
			return $this->render('step' . ($step + 1));
		}

		// for the last step, reset is_required to required to prevent hacking attemps
		$validates = AppModel::bulkValidate($this->models, $this->data, true);
		if (!$validates) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			return $this->render('step' . $step);
		}

		$this->saveRelatedData();

		// since this is the last step, make the gift complete
		$this->Gift->set(array('id' => $this->data['Gift']['id'], 'complete' => 1));
		$this->Gift->save(null, false);
		$this->saveSessionData();

		// credit card data is given
		// @todo if appeal or payment gateway use redirect model then redirect
		// else if the credit data is given, validates
		$errors = false;
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
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			return $this->render('step' . $step);
		}

		// everything ok prepare / perform the transaction
		//@todo dont always use the first one, make it dependent on the payment method 
		//@todo && the amount / currency vs. payment gateway fee by offices
		$gateway = $this->GatewaysOffice->find('by_office', array(
			'office_id' => $officeId
		));

		//@todo save payment data here?
		$this->Transaction->create(array(
			'gift_id' => $this->data['Gift']['id'],
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

		$this->dropSessionData();
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
		$appealId = $this->Session->read($this->sessAppealKey);
		$currentAppeal = $this->Appeal->find('default', array(
			'id' => $appealId
		));
		Assert::notEmpty($currentAppeal, '500');
		$this->viewPath = 'templates' . DS . $currentAppeal['Appeal']['campaign_code'] . '_' . $currentAppeal['Appeal']['id'];
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_thanks() {
		$msg = 'Donation added!';
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index($type = 'all') {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id')
		);

		$order = array('Gift.created' => 'desc');
		switch ($type) {
			case 'recurring':
				$conditions['Gift.frequency <>'] = 'onetime';
				$order = array('Gift.due' => 'desc');
				break;
			case 'onetime':
				$conditions['Gift.frequency'] = 'onetime';
				break;
			case 'starred':
				$conditions['Gift.id'] = $this->Session->read('favorites');
				break;
		}

		$defaults = array(
			'keyword' => '',
			'search_type' => 'all',
			'my_limit' => 20,
			'custom_limit' => false,
			'start_date_day' => false,
			'start_date_year' => false,
			'start_date_month' => false,
			'end_date_day' => false,
			'end_date_year' => false,
			'end_date_month' => false
		);
		$params = am($defaults, $this->params['url'], $this->params['named']);
		unset($params['ext']);
		unset($params['url']);

		if (is_numeric($params['custom_limit'])) {
			if ($params['custom_limit'] > 75) {
				$params['custom_limit'] = 75;
			}
			if ($params['custom_limit'] == 0) {
				$params['custom_limit'] = 50;
			}
			$params['my_limit'] = $params['custom_limit'];
		}

		// search was submitted
		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);
			switch ($params['search_type']) {
				case 'gift':
					$conditions['Gift.serial LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'appeal':
					$conditions['Appeal.name LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'person':
					$key = "CONCAT(Contact.fname,' ',Contact.lname)";
					$conditions[$key . ' LIKE'] = '%' . $params['keyword'] . '%';
					break;
				default:
					$conditions['or'] = array(
						'Gift.serial LIKE' => '%' . $params['keyword'] . '%',
						'Appeal.name LIKE' => '%' . $params['keyword'] . '%',
						'Office.name LIKE' => '%' . $params['keyword'] . '%',
						"CONCAT(Contact.fname,' ',Contact.lname) LIKE" => '%' . $params['keyword'] . '%'
					);
					break;
			}
		}

		$conditions = $this->GridFilter->dateRange($conditions, $params, 'Gift', 'created');
		$this->Session->write('gifts_filter_conditions', $conditions);
		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'recursive' => 3,
			'contain' => array(
				'Contact(fname, lname, email,created,modified,id)',
				'Transaction(id,status,gateway_id,created,modified)',
				'Transaction.Gateway(id,name)'
			),
			'limit' => $params['my_limit'],
			'order' => $order
		);

		$gifts = $this->paginate();
		$this->set(compact('gifts', 'type', 'params'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_add() {
		$this->params['named']['appeal_id'] = $this->Appeal->lookup(
			array(
				'office_id' => $this->Session->read('Office.id'),
				'name LIKE' => '%Admin%',
				'admin' => true
			), 'id', false
		);
		$this->add();
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id = null) {
		$gift = $this->Gift->find('first', array(
			'conditions' => compact('id')
		));
		Assert::notEmpty($gift, '404');
		Assert::true(User::allowed($this->name, $this->action, $gift), '403');

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
				'Office(id, name)', 'Appeal'
			)
		));
		Assert::notEmpty($gift, '404');
		Assert::true(User::allowed($this->name, $this->action, $gift), '403');

		$commentMethod = $this->Gift->hasMany['Comment']['threaded'] ? 'threaded' : 'all';
		$comments = $this->Gift->Comment->find($commentMethod, array(
			'conditions' => array('Comment.foreign_id' => $id),
			'contain' => array('User(login, id)')
		));
		$this->set(compact('gift', 'comments', 'commentMethod'));
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
	function checkForValidAppealId($step) {
		$msg = __('Please choose a country first!', true);

		if ($step == 1 && $this->isGet() && !isset($this->params['named']['appeal_id'])) {
			return $this->Message->add($msg, 'error', true, '/');
		}

		if (isset($this->params['named']['appeal_id'])) {
			$conditions = array('id' => $this->params['named']['appeal_id']);
			if (!User::isAdmin()) {
				$conditions['admin'] = false;
			}
			$existingAppeal = $this->Appeal->lookup($conditions, 'id', false);
			$sessAppealId = $this->Session->read($this->sessAppealKey);
			if (!$existingAppeal || $step != 1 && $sessAppealId != $existingAppeal) {
				return $this->Message->add($msg, 'error', true, '/');
			}

			$this->Session->write($this->sessAppealKey, $this->params['named']['appeal_id']);
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function saveRelatedData() {
		if (!isset($this->data['Contact']['id'])) {
			$this->Contact->create(array('gift_id' => $this->data['Gift']['id']));
			$this->Contact->save(null, false);
			$contactId = $this->Contact->getLastInsertId();
			$this->data['Gift']['contact_id'] = $contactId;
			$this->data['Contact']['id'] = $contactId;
		} else {
			$contactId = $this->data['Contact']['id'];
		}
		$this->Contact->save($this->data, false);
		$this->Gift->save($this->data, false);

		if (!isset($this->data['Address']['id'])) {
			$this->Address->create(array('contact_id' => $contactId));;
			$this->Address->save(null, false);
			$addressId = $this->Address->getLastInsertId();
			$this->data['Phone']['address_id'] = $addressId;
			$this->data['Address']['id'] = $addressId;
		} else {
			$addressId = $this->data['Address']['id'];
		}
		$this->Address->save($this->data, false);

		if (!isset($this->data['Phone']['id'])) {
			$this->Phone->create(array(
				'contact_id' => $contactId,
				'address_id' => $addressId
			));
			$this->Phone->save(null, false);
			$phoneId = $this->Phone->getLastInsertId();
			$this->data['Phone']['id'] = $phoneId;
		}
		$this->Phone->save($this->data, false);
	}
}
?>