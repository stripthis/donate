<?php
class GiftsController extends AppController {
	var $helpers = array('Fpdf', 'GiftForm', 'OpenFlashChart');
	var $components = array('Date');
	var $models = array('Gift', 'Contact', 'Address', 'Phone');
	var $sessAppealKey = 'gift_process_appeal_slug';
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
		$this->GiftType = $this->Gift->GiftType;
		$this->Frequency = $this->Gift->Frequency;
		$this->Address = $this->Contact->Address;
		$this->Phone = $this->Address->Phone;
		$this->Country = $this->Address->Country;
		$this->City = $this->Address->City;
		$this->Transaction = $this->Gift->Transaction;
		$this->TemplateStepVisit = ClassRegistry::init('TemplateStepVisit');
		$this->Card = ClassRegistry::init('Card');
	}
/**
 * undocumented function
 *
 * @param string $step
 * @return void
 * @access public
 */
	function add($step = 1) {
		$this->checkForValidAppealId($step);

		$appealSlug = $this->Session->read($this->sessAppealKey);
		$currentAppeal = $this->Appeal->find('default', array('slug' => $appealSlug));
		$appealId = $currentAppeal['Appeal']['id'];

		if (!$currentAppeal['Office']['live']) {
			return $this->redirect($currentAppeal['Office']['external_url']);
		}

		Assert::notEmpty($currentAppeal, '500');
		$officeId = $currentAppeal['Appeal']['office_id'];
		$this->Session->write($this->sessOfficeKey, $officeId);

		$templateId = $currentAppeal['Template']['id'];
		$this->data['Gift']['appeal_id'] = $currentAppeal['Appeal']['id'];
		$this->viewPath = 'templates' . DS . $currentAppeal['Template']['slug'] . '_' . $templateId;

		$countryOptions = $this->Country->find('list', array('order' => array('Country.name' => 'asc')));
		$this->set(compact('countryOptions', 'currentAppeal'));

		// no data was given so we render the selected/default view
		if ($this->isGet()) {
			if (!file_exists(VIEWS . $this->viewPath . DS . 'step' . $step . '.ctp')) {
				return;
			}
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		}

		$this->loadSessionData($this->data);
		$this->City->injectCityId($this->data);

		if (!isset($this->data['Gift']['gift_type_id'])) {
			$this->data['Gift']['gift_type_id'] = $this->GiftType->lookup(
				array('name' => 'donation'), 'id', false
			);
		}
		if (!isset($this->data['Gift']['id']) || empty($this->data['Gift']['id'])) {
			$data = array(
				'complete' => 0,
				'office_id' => $officeId
			);
			if (!User::is('guest')) {
				$data['user_id'] = User::get('id');
			}
			$this->Gift->create($data);
			$this->Gift->save(null, false);
			$this->data['Gift']['id'] = $this->Gift->getLastInsertId();
		}

		if (isset($this->data['Gift']['amount_other']) && !empty($this->data['Gift']['amount_other'])) {
			$this->data['Gift']['amount'] = $this->data['Gift']['amount_other'];
		}

		$isLastStep = $step == $currentAppeal['Template']['template_step_count'];

		$validates = AppModel::bulkValidate($this->models, $this->data);

		if (!$isLastStep && !$validates) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		}

		if (!$isLastStep && $validates) {
			$this->saveRelatedData();
			$this->saveSessionData();
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step + 1);
			return $this->render('step' . ($step + 1));
		}

		// for the last step, reset is_required to required to prevent hacking attemps
		$validates = AppModel::bulkValidate($this->models, $this->data, true);
		if (!$validates) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		}

		if (!isset($this->data['Gift']['eula'])) {
			$this->data['Contact']['contactable'] = '0';
		} elseif (!$this->data['Gift']['eula']) {
			$msg = __('You have to accept the terms of conditions.', true);
			$this->Message->add($msg, 'error');
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		} else {
			$this->data['Contact']['contactable'] = '1';
		}

		$this->saveRelatedData();

		// since this is the last step, make the gift complete
		$this->Gift->set(array('id' => $this->data['Gift']['id'], 'complete' => 1));
		$this->Gift->save(null, false);
		$this->saveSessionData();

		// credit card data is given
		// else if the credit data is given, validates
		$errors = false;
		if (isset($this->data['Card']) && $currentAppeal['Appeal']['GatewayProcessing']['label'] != 'redirect') {
			$this->Card->set($this->data);
			if (true || $this->Card->validates()) {
				// @todo if application used in manual/direct debit mode, save credit card details
				// But for now: *WE DON'T SAVE*
			} else {
				$errors = true;
			}
		}

		if ($errors) {
			$msg = 'There are problems with the form.';
			$this->Message->add($msg, 'error');
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		}

		$gateway = $this->GatewaysOffice->find('by_office', array(
			'office_id' => $officeId
		));

		$this->Transaction->create(array(
			'gift_id' => $this->data['Gift']['id'],
			'currency_id' => $this->data['Gift']['currency_id'],
			'office_id' => $officeId,
			'amount' => $this->data['Gift']['amount'],
			'gateway_id' => $gateway['GatewaysOffice']['gateway_id']
		));
		$this->Transaction->save();
		$tId = $this->Transaction->getLastInsertId();

		$result = $this->Transaction->process($tId);

		if (is_string($result)) {
			$this->dropSessionData();
			return $this->redirect($result);
		}

		if ($result !== true) {
			$msg = sprintf(__('There was a problem processing the transaction: %s', true), $result);
			$this->Message->add($msg, 'error');
			$this->TemplateStepVisit->trackHit($templateId, $appealId, $step);
			return $this->render('step' . $step);
		}

		$this->dropSessionData();
		$keyData = $this->_addAuthkeyToSession($tId);
		if (Configure::read('App.Tax_receipt.enabled')) {
			$this->Gift->emailReceipt($this->data['Contact']['email'], $keyData);
		}

		$this->redirect(array('action' => 'thanks'));
	}
/**
 * undocumented function
 *
 * @param string $key
 * @param string $tId
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

		$templateId = $currentAppeal['Template']['id'];
		$this->TemplateStepVisit->trackHit($templateId, $appealId, 'thanks');
		$this->viewPath = 'templates' . DS . $currentAppeal['Template']['slug'] . '_' . $templateId;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index($type = 'all') {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$params = $this->_parseGridParams();
		$conditions = $this->_conditions($type, $params);
		$this->Session->write('gifts_filter_conditions', $conditions);

		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'recursive' => 3,
			'contain' => array(
				'Frequency(humanized)',
				'GiftType(humanized)',
				'Contact(fname, lname, email,created,modified,id)',
				'Contact.Address(zip,country_id,state_id)',
				'Contact.Address.Country',
				'Contact.Address.State',
				'Contact.Address.City',
				'Transaction(id,status,gateway_id,created,modified)' => 'Gateway(id,name)',
				'Currency(id,name,sign,iso_code)',
				'Appeal(name)'
			),
			'limit' => $params['my_limit'],
			'order' => $type != 'recurring'
						? array('Gift.created' => 'desc')
						: array('Gift.due' => 'desc')
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
	function admin_add($contactId = false) {
		$countryOptions = $this->Country->find('list', array(
			'order' => array('Country.name' => 'asc')
		));
		$appealOptions = $this->Appeal->find('list', array(
			'conditions' => array('office_id' => $this->Session->read('Office.id')),
			'order' => array('Appeal.name' => 'asc')
		));
		$contact = $this->Contact->findById($contactId);
		$this->set(compact('countryOptions', 'contact', 'appealOptions'));

		if ($this->isGet()) {
			return;
		}

		$this->data['Gift']['office_id'] = $this->Session->read('Office.id');

		$this->Gift->create($this->data);
		if (!$this->Gift->save()) {
			$msg = __('There was a problem saving the gift.', true);
			return $this->Message->add($msg, 'error');
		}
		$msg = __('The gift was successfully added!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'add', $contactId));
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

		$this->Gift->set(array('id' => $id, 'archived' => '1'));
		$this->Gift->save();
		$msg = __('Successfully deleted!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
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
				'Contact.Address.Phone',
				'Contact.Address.Country(id, name)',
				'Contact.Address.State(id, name)',
				'Contact.Address.City(id, name)',
				'GiftType(humanized)',
				'Office(id, name)', 'Appeal', 'Frequency', 'Currency(iso_code)'
			)
		));
		Assert::notEmpty($gift, '404');
		Assert::true(User::allowed($this->name, $this->action, $gift), '403');

		$this->paginate['Transaction'] = array(
			'conditions' => array('Transaction.gift_id' => $id),
			'contain' => array(
				'Gateway(name)',
				'Currency(iso_code)'
			),
			'order' => array('Transaction.created' => 'asc')
		);
		$transactions = $this->paginate('Transaction');

		$this->Gift = ClassRegistry::init('Gift');
		$commentMethod = $this->Gift->hasMany['Comment']['threaded'] 
							? 'threaded' : 'all';
		$comments = $this->Gift->Comment->find($commentMethod, array(
			'conditions' => array('Comment.foreign_id' => $id),
			'contain' => array('User(login, id)')
		));
		$this->set(compact('gift', 'comments', 'commentMethod', 'transactions'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_stats() {
		$this->_handleTimePeriod();
		$format = '%Y-%m-%d';
		if ($this->diagramType == 'hour') {
			$format = '%Y-%m-%d %H:00';
		}
		$gifts = $this->Gift->find('all', array(
			'conditions' => array(
				'office_id' => $this->Session->read('Office.id'),
				"DATE_FORMAT(created, '" . $format . "') >= '" . $this->startDate . "'",
				"DATE_FORMAT(created, '" . $format . "') <= '" . $this->endDate . "'",
			),
			'fields' => array('created', 'amount', 'archived', 'complete')
		));

		$result = array();

		$type = $this->diagramType;

		$items = DateComponent::diff($type, $this->startDate, $this->endDate, false);

		foreach ($items as $item) {
			$result[$item] = array();
			foreach ($gifts as $gift) {
				if (DateComponent::same($gift['Gift']['created'], $item, $type)) {
					$result[$item][] = $gift;
				}
			}
		}

		$this->set(compact('result', 'gifts', 'months', 'type'));
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
		$userId = !User::is('guest') ? User::get('id') : $this->data['Contact']['email'];
		$authKeyTypeId = $this->AuthKeyType->lookup(array('name' => 'Transaction Receipt'), 'id', false);
		$authKey = AuthKey::generate(array(
			'user_id' => $userId
			, 'auth_key_type_id' => $authKeyTypeId
			, 'foreign_id' => $tId
			, 'expires' => date('Y-m-d H:i:s', strtotime('+3 days'))
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

		if ($step == 1 && $this->isGet() && !isset($this->params['named']['appeal'])) {
			return $this->Message->add($msg, 'error', true, '/');
		}

		if (isset($this->params['named']['appeal'])) {
			$conditions = array('slug' => $this->params['named']['appeal']);
			$existingAppeal = $this->Appeal->lookup($conditions, 'slug', false);
			$sessAppealId = $this->Session->read($this->sessAppealKey);
			if (!$existingAppeal || $step != 1 && $sessAppealId != $existingAppeal) {
				return $this->Message->add($msg, 'error', true, '/');
			}

			$this->Session->write($this->sessAppealKey, $this->params['named']['appeal']);
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
/**
 * undocumented function
 *
 * @param string $type 
 * @param string $params 
 * @return void
 * @access public
 */
	function _conditions($type, $params) {
		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id'),
			'Gift.archived' => '0'
		);
		$onetime = $this->Frequency->lookup('onetime', 'id', false);
		switch ($type) {
			case 'recurring':
				$conditions['Gift.frequency_id <>'] = $onetime;
				break;
			case 'onetime':
				$conditions['Gift.frequency_id'] = $onetime;
				break;
			case 'favorites':
			case 'starred':
				$conditions['Gift.id'] = $this->Session->read('favorites');
				break;
			case 'archived':
				$conditions['Gift.archived'] = '1';
				break;
		}

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
						'GiftType.humanized LIKE' => '%' . $params['keyword'] . '%',
						"CONCAT(Contact.fname,' ',Contact.lname) LIKE" => '%' . $params['keyword'] . '%'
					);
					break;
			}
		}
		return $this->Gift->dateRange($conditions, $params, 'created');
	}
}
?>