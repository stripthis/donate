<?php
class Contact extends AppModel {
	var $hasMany = array(
		'Address'
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
		),
		'address' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The address is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid address.',
			)
		),
		/*'address2' => array(
			// allow empty
		),*/
		'city' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The city is required!',
				'required' => true,
				'last' => true
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a city.',
			),
			'valid' => array(
				'rule' => array('validateCity'),
				'message' => 'Please provide a valid city.'
			)
		),
		'zip' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a zip code.',
			),
			'valid' => array(
				'rule' => array('validateZip'),
				'message' => 'Please provide a valid zip code.',
				'required' => false,
				'allowEmpty' => true,
			)
		),
		'state_id' => array(
			'valid' => array(
				'rule' => array('validateState'),
				'message' => 'Please provide a valid state.',
				'required' => false,
				'allowEmpty' => true,
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
		)
	);
}
?>