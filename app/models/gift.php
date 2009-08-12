<?php
class Gift extends AppModel {
	var $belongsTo = array(
		'User', 'Appeal', 'Office', 'Contact'
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
		'amount' => array(
			'valid' => array(
				'rule' => array('money'),
				'message' => 'Please provide valid amount (ex: 31.45)',
			),
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The amount is required!',
				'required' => true,
				'last' => true
			),
			'mini' => array(
				'rule' => array('validateAmount'),
				'message' => 'Sorry, this amount is too small.',
				'required' => true,
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
		)
	);
/**
 * Deliver mail receipt
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
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateFrequency($check) {
		return array_key_exists(current($check), Gift::getFrequencies());
	}
/**
 * Validate a gift type
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		return array_key_exists($check['type'], Gift::getTypes());
	}
/**
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmount($check){
		return (isset($check['amount']) && $check['amount'] >= Gift::getMinimumAmount());
	}
/**
 * Return the default proposed frequencies
 * @return array, allowed frequency options
 */
	static function getTypes(){
		 return Configure::read('App.gift.types');
	}
/**
 * Return the default proposed frequencies
 * @return array, allowed frequency options
 */
	static function getFrequencies(){
		 return Configure::read('App.gift.frequencies');
	}
/**
 * Return the different amounts proposed by default 
 * @return array, allowed amount options
 */
	static function getAmounts(){
		 return Configure::read('App.gift.amounts');
	}
/**
 * 
 * @return number, minimal amount as defined in the configuration file
 */
	static function getMinimumAmount(){
		 $amounts = Configure::read('App.gift.amounts');
		 return $amounts[0];
	}
/**
 * Return the allowed currencies
 * @return array, allowed currencies as defined in the configuration file
 */
	static function getCurrencies(){
		//@todo to be based on payment gateway(s) capability
		return Configure::read('App.gift.currencies');
	}
}
?>