<?php
class Gift extends AppModel {
	var $belongsTo = array(
		'User', 'Appeal', 'Country', 'Office'
	);

	var $hasMany = array(
		'Transaction' => array('dependent' => true),
		'Comment' => array(
			'dependent' => true,
			'foreignKey' => 'foreign_id'
		)
	);

	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'create'
		),
		'type' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The type is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'validateType',
				'message' => 'This is an invalid type.',
			)
		),
		'amount' => array(
			'valid' => array(
				'rule' => array('money'),
				'message' => 'Please provide an amount in the form dd.dd where d is a digit.',
			),
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The amount is required!',
				'required' => true,
				'last' => true
			),
		),
		'fname' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The first name is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+$/'),
				'message' => 'Please provide a valid first name.',
			),
			'length' => array(
				'rule' => array('minLength', '2'),
				'message' => 'Your first name must have at least 2 characters.',
			),
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
		'address' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The address name is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid address.',
			)
		),
		'zip' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The zip is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid zip code.',
			)
		),
		'country_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The country is required!',
				'required' => true,
				'last' => true
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a country.',
			),
			'valid' => array(
				'rule' => array('validateCountry'),
				'message' => 'Please provide a valid country.'
			)
		),
		'office_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The office is required!',
				'required' => true,
				'last' => true
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide an office.',
			),
			'valid' => array(
				'rule' => array('validateOffice'),
				'message' => 'Please provide a valid office.'
			)
		),
		'frequency' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The frequency is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array('validateFrequency'),
				'message' => 'Please provide a valid frequency.'
			)
		),
		'email' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The email is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array('email', false),
				'allowEmpty' => false,
				'message' => 'This is not a valid email address.'
			),
			'maxlength' => array(
				'rule' => array('maxLength', '80'),
				'message' => 'The email must consist of 80 or less characters.',
			)
		),
		'terms' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The terms field is required!',
				'required' => true,
				'last' => true
			),
			'accepted' => array(
				'rule' => array('equalTo', '1'),
				'message' => 'Please accept the terms.'
			)
		),
	);
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateCountry($check) {
		$country = ClassRegistry::init('Country')->lookup(
			array('id' => current($check)), 'id', false
		);
		return !empty($country);
	}
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateOffice($check) {
		$office = ClassRegistry::init('Office')->lookup(
			array('id' => current($check)), 'id', false
		);
		return !empty($office);
	}
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateFrequency($check) {
		return array_key_exists(current($check), Configure::read('App.frequency_options'));
	}
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		return array_key_exists($check['type'], Configure::read('App.gift_types'));
	}
/**
 * undocumented function
 *
 * @param string $email 
 * @param string $authKey 
 * @return void
 * @access public
 */
	function emailReceipt($email, $authKey) {
		$emailSettings = array(
			'vars' => array(
				'keyData' => $authKey
			),
			'mail' => array(
				'to' => $email
				, 'subject' => Configure::read('App.name') . ': Your Tax Receipt'
			),
			'store' => false
		);
		Mailer::deliver('receipt', $emailSettings);
	}
}
?>