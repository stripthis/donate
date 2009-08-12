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
		),/*
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
		),*/
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
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmount($check){
		return (isset($check['amount']) && $check['amount'] >= Configure::read('App.gift_mini'));
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
/**
 * Get Months for gift date select options (credit card)
 * @return key value for month selection
 */
	static function getMonthOptions(){
		$months = array(
			"01" => "01", "02" => "02", "03" => "03",
			"04" => "04",	"05" => "05",	"06" => "06",
			"07" => "07",	"08" => "08",	"09" => "09",
			"10" => "10",	"11" => "11",	"12" => "12",
		);
		return $months;
	}
/**
 * Get Years for gift date select options (credit card)
 * @return key value for year selection
 */
	static function getYearOptions(){
		$years = array();
		$y = (date("Y", strtotime("now")));
		for ($i=$y;$i<=$y+10;$i++) {
			$years[$i] = $i;
		}
		return $years;
	}
}
?>