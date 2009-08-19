<?php
class Contact extends AppModel {
	var $hasMany = array(
		'Address',
		'Phone'
	);

	var $belongsTo = array(
		'User',
	);
	
	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'create'
		),
		'fname' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The first name is required!',
				'last' => true
			),
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+$/'),
				'message' => 'Please provide a valid first name.',
				'is_required' => true,
				'allowEmpty' => true,
			)
		),
		'lname' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The last name is required!',
				'is_required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu}\s]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu}]+$/'),
				'message' => 'Please provide a valid last name.',
			),
			'length' => array(
				'rule' => array('minLength', '2'),
				'message' => 'Your last name must have at least 2 characters.',
			),
		),
		'email' => array(
			'valid' => array(
				'rule' => 'email',
				'message' => 'Please enter a valid email address.',
				'is_required' => true,
			)
		)
	);
/**
 * undocumented function
 *
 * @param string $data 
 * @return void
 * @access public
 */
	function addFromGift($data) {
		if (isset($data['Contact']['id'])) {
			$contactFound = $this->find('count', array(
				'conditions' => array('id' => $data['Contact']['id']),
				'contain' => false
			)) > 0;
			Assert::true($contactFound, '404');
			return $data['Contact']['id'];
		}

		// mechanisms to prevent duplication will be added later
		$this->create($data['Contact']);
		$this->Address->create($data['Address']);
		$this->Phone->create($data['Phone']);
		$this->Address->validates();
		$this->Phone->validates();

		if ($this->validates()) {
			$this->save();
			$contactId = $this->getLastInsertId();

			$addressData = am($data['Address'], array('contact_id' => $contactId));

			$conditions = array(
				'country_id' => $data['Address']['country_id'],
				'name' => $data['Address']['city_id']
			);
			if (isset($data['Address']['state_id'])) {
				$conditions['state_id'] = $data['Address']['state_id'];
			}
			$addressData['city_id'] = $this->Address->City->lookup($conditions, 'id', true);

			$this->Address->create($addressData);
			if ($this->Address->validates()) {
				$this->Address->save();
				$addressId = $this->Address->getLastInsertId();

				if (empty($data['Phone']['phone'])) {
					return $contactId;
				}
				$this->Phone->create(am($data['Phone'], array('contact_id' => $contactId, 'address_id' => $addressId)));
				if ($this->Phone->save()) {
					return $contactId;
				}
			}
		}
		return false;
	}
/**
 * Get the list of allowed salutations
 * @return array
 */
	static function getSalutations() {
		return Configure::read("App.contact.salutations");
	}
/**
 * Get the list of allowed titles
 * @return array
 */
	static function getTitles() {
		return Configure::read("App.contact.titles");
	}
}
?>