<?php
class City extends AppModel{
	var $belongsTo = array(
		'State', 'Country'
	);
	
	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'create'
		),
		'name' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The city name is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+$/'),
				'message' => 'Please provide a valid city name.',
			),
			'length' => array(
				'rule' => array('minLength', '2'),
				'message' => 'Your city name must have at least 2 characters.',
			),
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
		'state_id' => array(
			'valid' => array(
				'rule' => array('validateState'),
				'message' => 'Please provide a valid state.',
				'required' => false,
				'allowEmpty' => true,
			)
		)
	);
}
?>