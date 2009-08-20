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
				'is_required' => true,
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
		),
		'state_id' => array(
			'valid' => array(
				'rule' => array('validateState'),
				'message' => 'Please provide a valid state.',
				'is_required' => false,
				'allowEmpty' => true,
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
	function injectCityId(&$data) {
		if (!isset($data['Address'])) {
			return false;
		}

		$city = isset($data['Address']['city'])
				? $data['Address']['city']
				: $data['Address']['city_id'];
		$conditions = array(
			'country_id' => $data['Address']['country_id'],
			'name' => $city
		);
		if (isset($data['Address']['state_id'])) {
			$conditions['state_id'] = $data['Address']['state_id'];
		}
		$data['Address']['city_id'] = $this->lookup($conditions, 'id', true);
	}
}
?>