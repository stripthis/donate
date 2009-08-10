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
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+$/'),
				'message' => 'Please provide a valid first name.',
				'required' => false,
				'allowEmpty' => true,
			)
		),
		'lname' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The last name is required!',
				'required' => true,
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
				'required' => true,
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
		if (!isset($data['Contact'])) {
			return false;
		}

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
		if (!$this->save()) {
			return false;
		}

		$contactId = $this->getLastInsertId();

		$addressData = am($data['Address'], array('contact_id' => $contactId));

		$conditions = array(
			'country_id' => $data['Address']['country_id'],
			'name' => $data['City']['name']
		);
		if (isset($data['Address']['state_id'])) {
			$conditions['state_id'] = $data['Address']['state_id'];
		}
		$addressData['city_id'] = $this->Address->City->lookup($conditions, 'id', true);

		$this->Address->create($addressData);
		if (!$this->Address->save()) {
			return false;
		}
		$addressId = $this->Address->getLastInsertId();

		$this->Phone->create(am($data['Phone'], array('contact_id' => $contactId, 'address_id' => $addressId)));
		if (!$this->Phone->save()) {
			return false;
		}

		return $contactId;
	}
}
?>