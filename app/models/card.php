<?php
class Card extends AppModel {
	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'update'
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
		'expire_month' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'last' => true
			)
		),
		'expire_year' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'last' => true
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
		return array_key_exists($check['type'], Configure::read('App.card_types'));
	}
}
?>