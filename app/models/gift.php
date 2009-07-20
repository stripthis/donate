<?php
class Gift extends AppModel {
	var $belongsTo = array(
		'User',
		'Appeal'
	);

	var $hasMany = array(
		'Transaction'
	);

	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'create'
		),
		'type' => array(
			'valid' => array(
				'rule' => 'validateType',
				'message' => 'This is an invalid type.'
			)
		),
		'amount' => array(
			'valid' => array(
				'rule' => array('money'),
				'message' => 'Please provide an amount in the form dd.dd where d is a digit.',
			)
		),
		'description' => array(
			'valid' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please provide a description. This is useful for your tax receipt.'
			)
		),
		'fname' => array(
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu}\-,]+$/'),
				'message' => 'Please provide a valid first name.'
			),
			'length' => array(
				'rule' => array('minLength', '2'),
				'message' => 'Your first name must have at least 2 characters.'
			),
		),
		'lname' => array(
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu}\-,]+$/'),
				'message' => 'Please provide a valid last name.'
			),
			'length' => array(
				'rule' => array('minLength', '2'),
				'message' => 'Your last name must have at least 2 characters.'
			),
		),
		'address' => array(
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid address.'
			)
		),
		'zip' => array(
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid zip code.'
			)
		),
		'country_id' => array(
			'valid' => array(
				'rule' => array('validateCountry'),
				'message' => 'Please provide a valid address.'
			)
		),
		'frequency' => array(
			'valid' => array(
				'rule' => array('validateFrequency'),
				'message' => 'Please provide a valid frequency.'
			)
		),
		'email' => array(
			'required' => array(
				'rule' => VALID_NOT_EMPTY,
				'message' => 'Email must not be empty.',
			),
			'valid' => array(
				'rule' => array('email', false),
				'message' => 'This is not a valid email address.'
			),
			'maxlength' => array(
				'rule' => array('maxLength', '80'),
				'message' => 'The email must consist of 80 or less characters.',
			)
		),
		'terms' => array(
			'required' => array(
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
		$countryId = current($check);

		$country = ClassRegistry::init('Country')->lookup(array('id' => $countryId), 'id', false);
		return !empty($country);
	}
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateFrequency($check) {
		$value = current($check);

		return array_key_exists($value, Configure::read('App.frequency_options'));
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
}
?>