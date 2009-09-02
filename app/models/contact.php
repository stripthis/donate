<?php
class Contact extends AppModel {
	var $hasMany = array(
		'Address',
		'Phone',
		'Gift'
	);

	var $hasOne = array('User');

	var $validate = array(
		'fname' => array(
			'valid' => array(
				'allowEmpty' => true,
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu}\s]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu}]+$/'),
				'is_required' => true,
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
				'is_required' => true,
				'message' => 'Please enter a valid email address.'
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

		if (!isset($this->data['Contact']['fname']) || !isset($this->data['Contact']['lname'])) {
			return true;
		}
		$ids = $this->Gift->find('all', array(
			'conditions' => array('Gift.contact_id' => $this->id),
			'fields' => array('id')
		));
		$ids = Set::extract('/Gift/id', $ids);
		foreach ($ids as $id) {
			$this->Gift->name($id);
		}

		$user = $this->User->find('first', array(
			'conditions' => array('User.contact_id' => $this->id),
			'fields' => array('id')
		));

		$this->User->recursive = -1;
		$this->User->updateAll(
			array('name' => '"' . $this->data['Contact']['fname'] . ' ' . $this->data['Contact']['lname'] . '"'),
			array('User.id' => $user['User']['id'])
		);
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