<?php
class Address extends AppModel {
	var $belongsTo = array(
		'User',
		'Country',
		'State',
		'City'
	);

	var $hasMany = array('Phone');

	var $validate = array(
		'line_1' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The address is required!',
				'is_required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'notEmpty',
				'message' => 'Please provide a valid address.',
			)
		),
		'city' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'The city is required!',
				'is_required' => true,
				'last' => true
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
				'is_required' => true,
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
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateZip($check) {
		//echo "validate zip";
		//pr($this->data['City']);
		//exit;
		return true;
	}
}
?>