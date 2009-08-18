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
		// @todo attach current office id here
		return array_key_exists(current($check), Gift::find('frequencies'));
	}
/**
 * Validate a gift type
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		// @todo attach current office id here
		return array_key_exists($check['type'], Gift::find('types'));
	}
/**
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmount($check){
		// @todo attach current office id here
		return (isset($check['amount']) && $check['amount'] >= Gift::find('min_amount'));
	}
/**
 * undocumented function
 *
 * @param string $type 
 * @param string $query 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'types':
				return array(
					'donation' => 'Donation'
					//,'inkind' => 'In-kind gift'
					//,'legacy' => 'Legacy'
				);
			case 'frequencies':
				$frequencies = array('onetime', 'monthly', 'quarterly', 'biannually', 'annualy');
				if (!isset($query['options']) && isset($query['id'])) {
					$frequencies = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
						'contain' => false,
						'fields' => array('frequencies')
					));
					$frequencies = explode(',', $frequencies['Office']['frequencies']);
				}

				$result = array();
				foreach ($frequencies as $frequency) {
					$result[$frequency] = Inflector::humanize($frequency);
				}
				return $result;
			case 'amounts':
				$amounts = '5,10,15';
				if (!isset($query['options']) && isset($query['id'])) {
					$amounts = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
						'contain' => false,
						'fields' => array('amounts')
					));
					$amounts = $amounts['Office']['amounts'];
				}
				return $amounts;
			case 'min_amount':
				$amounts = Gift::find('amounts', $query);
				return $amounts[0];
			case 'currencies':
				return array('EUR', 'USD', 'GBP');
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>