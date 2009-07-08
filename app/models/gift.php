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
		)
	);
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