<?php
class Contact extends AppModel {
	var $hasMany = array(
		'Address',
		'Phone',
		'Gift'
	);

	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'create'
		),
		'fname' => array(
			'valid' => array(
				'allowEmpty' => true,
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu}\s]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu}]+$/'),
				'message' => 'Please provide a valid last name.',
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
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($created) {
		if ($created) {
			return true;
		}

		$ids = $this->Gift->find('all', array(
			'conditions' => array('Gift.contact_id' => $this->id),
			'contain' => false,
			'fields' => array('id')
		));
		$ids = Set::extract('/Gift/id', $ids);
		foreach ($ids as $id) {
			$this->Gift->name($id);
		}
	}
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
		$this->Address->validates();

		if (isset($data['Phone'])) {
			$this->Phone->create($data['Phone']);
			$this->Phone->validates();
		}

		if ($this->validates()) {
			$this->save();
			$contactId = $this->getLastInsertId();

			$addressData = am($data['Address'], array('contact_id' => $contactId));

			$this->Address->create($addressData);
			if ($this->Address->validates()) {
				$this->Address->save();
				$addressId = $this->Address->getLastInsertId();

				if (!isset($data['Phone']) || empty($data['Phone']['phone'])) {
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