<?php
class Office extends AppModel {
	var $belongsTo = array(
		'ParentOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'SubOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		),
		'GatewaysOffice' => array(
			'dependent' => true
		),
		'FrequenciesOffice' => array(
			'dependent' => true
		),
		'CountriesOffice' => array(
			'dependent' => true
		),
		'LanguagesOffice' => array(
			'dependent' => true
		),
		'CurrenciesOffice' => array(
			'dependent' => true
		),
		'GiftTypesOffice' => array(
			'dependent' => true
		),
		'Appeal' => array(
			'dependent' => true
		),
		'User' => array(
			'dependent' => true
		),
		'Gift' => array(
			'dependent' => true
		)
	);

	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewaysOffice'
		),
		'Frequency' => array(
			'with' => 'FrequenciesOffice'
		),
		'Language' => array(
			'with' => 'LanguagesOffice'
		),
		'Country' => array(
			'with' => 'CountriesOffice'
		),
		'Currency' => array(
			'with' => 'CurrenciesOffice'
		),
	);

	var $validate = array(
		'frequencies' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify at least one frequency option!',
				'last' => true
			)
		),
		'amounts' => array(
			'required' => array(
				'rule' => array('validateAmounts'),
				'message' => 'Please specify valid amount options!',
				'last' => true
			),
		),
	);
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		if (isset($this->data['Office']['amounts'])) {
			$this->data['Office']['amounts'] = r(' ', '', $this->data['Office']['amounts']);
		}

		if (isset($this->data[__CLASS__]['languages'])) {
			$this->languages = $this->data[__CLASS__]['languages'];
		}

		if (isset($this->data[__CLASS__]['currencies'])) {
			$this->currencies = $this->data[__CLASS__]['currencies'];
		}

		if (isset($this->data[__CLASS__]['frequencies'])) {
			$this->frequencies = $this->data[__CLASS__]['frequencies'];
		}

		if (isset($this->data[__CLASS__]['gift_types'])) {
			$this->giftTypes = $this->data[__CLASS__]['gift_types'];
		}

		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function afterSave($created) {
		if (isset($this->data['Office']['gateways'])) {
			$this->GatewaysOffice->deleteAll(array('office_id' => $this->id));
			if (!empty($this->data['Office']['gateways'][0])) {
				foreach ($this->data['Office']['gateways'] as $gatewayId) {
					$this->GatewaysOffice->create(array(
						'office_id' => $this->id,
						'gateway_id' => $gatewayId
					));
					$this->GatewaysOffice->save();
				}
			}
		}

		if (isset($this->frequencies)) {
			$this->FrequenciesOffice->deleteAll(array('office_id' => $this->id));

			$options = explode(',', $this->frequencies);
			foreach ($options as $frequencyId) {
				$this->FrequenciesOffice->create(array(
					'office_id' => $this->id,
					'frequency_id' => $frequencyId
				));
				$this->FrequenciesOffice->save();
			}
		}

		if (isset($this->languages)) {
			$this->LanguagesOffice->deleteAll(array('office_id' => $this->id));

			foreach ($this->languages as $langId) {
				$this->LanguagesOffice->create(array(
					'office_id' => $this->id,
					'language_id' => $langId
				));
				$this->LanguagesOffice->save();
			}
		}

		if (isset($this->giftTypes)) {
			$this->GiftTypesOffice->deleteAll(array('office_id' => $this->id));

			foreach ($this->giftTypes as $typeId) {
				$this->GiftTypesOffice->create(array(
					'office_id' => $this->id,
					'gift_type_id' => $typeId
				));
				$this->GiftTypesOffice->save();
			}
		}

		if (isset($this->currencies)) {
			$this->CurrenciesOffice->deleteAll(array('office_id' => $this->id));

			foreach ($this->currencies as $curr) {
				$this->CurrenciesOffice->create(array(
					'office_id' => $this->id,
					'currency_id' => $curr
				));
				$this->CurrenciesOffice->save();
			}
		}

		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeValidate() {
		if (empty($this->data['Office']['frequencies'])) {
			$this->data['Office']['frequencies'] = array();
		}
		$this->data['Office']['frequencies'] = implode(',', $this->data['Office']['frequencies']);
		return true;
	}
/**
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmounts($check) {
		$check = explode(',', current($check));
		foreach ($check as $amount) {
			if (!is_numeric($amount)) {
				return false;
			}
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	static function isOwn($id) {
		$isMyOffice = $id == User::get('office_id');

		$_this = ClassRegistry::init(__CLASS__);
		$subOffices = $_this->find('all', array(
			'conditions' => array('parent_id' => User::get('office_id')),
			'fields' => array('id')
		));
		$isValidSubOffice = in_array($id, Set::extract('/Office/id', $subOffices));

		return $isValidSubOffice || $isMyOffice || User::is('root');
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function activate($id) {
		$office = $this->find('first', array(
			'conditions' => array('Office.id' => $id),
			'contain' => array(
				'SubOffice(id, name, parent_id)', 'ParentOffice(id, name, parent_id)'
			),
			'fields' => array('Office.id', 'Office.name', 'Office.parent_id')
		));

		if (isset($office['Office'])) {
			$newOffice = $office['Office'];
			$newOffice['ParentOffice'] = $office['ParentOffice'];
			$newOffice['SubOffice'] = $office['SubOffice'];
			$office = $newOffice;
		}

		$Session = Common::getComponent('Session');
		$Session->write('Office', $office);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function reload($id) {
		$Session = Common::getComponent('Session');
		if ($id == $Session->read('Office.id')) {
			$this->activate($id);
		}
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	public function subRelations($id, $data) {
		$this->updateAll(
			array('Office.parent_id' => "''"),
			array('Office.parent_id' => $id)
		);

		if (!is_array($data['Office']['suboffice_id'])) {
			return false;
		}

		foreach ($data['Office']['suboffice_id'] as $subOfficeId) {
			$this->id = $subOfficeId;
			$this->saveField('parent_id', $id);
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
			case 'root_options':
				if (!User::is('root')) {
					return array();
				}
				return $this->find('list', array(
					'order' => array('name' => 'desc')
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>