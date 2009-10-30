<?php
class Gift extends AppModel {
	var $actsAs = array(
		'Serialable',
		'ContinuousId' => array('offset' => '100000')
	);

	var $belongsTo = array(
		'Contact', 'User', 'Appeal', 'Office',
		'Frequency', 'GiftType', 'Currency'
	);

	var $hasMany = array(
		'Transaction' => array('dependent' => true)
	);

	var $hasOne = array(
		'LastTransaction' => array(
			'className' => 'Transaction',
			'type' => 'left',
			'limit' => 1
		), 
	);

	var $validate = array(
		'gift_type_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The type is required!',
				'is_required' => true,
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
				'is_required' => true,
				'last' => true
			),
			'mini' => array(
				'rule' => array('validateAmount'),
				'message' => 'Sorry, this amount is too small.',
			)
		),
		'frequency_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The frequency is required!',
				'is_required' => true,
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
		return array_key_exists(current($check), Gift::find('frequencies'));
	}
/**
 * Validate a gift type
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		return array_key_exists(current($check), Gift::find('gift_types'));
	}
/**
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmount($check){
		$Session = Common::getComponent('Session');
		return (isset($check['amount']) && $check['amount'] >= Gift::find('min_amount', array(
			'id' => $Session->read('gift_process_office_id')
		)));
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
			case 'gift_types':
				$query['office_id'] = Gift::officeId();

				$conditions = array();
				if (!empty($query['office_id'])) {
					$conditions['GiftTypesOffice.office_id'] = $query['office_id'];
				}

				$types = ClassRegistry::init('GiftTypesOffice')->find('all', array(
					'conditions' => $conditions,
					'contain' => array('GiftType(name, id, humanized)'),
					'order' => array('GiftType.name' => 'asc')
				));
				$result = array();
				foreach ($types as $t) {
					$result[$t['GiftType']['id']] = $t['GiftType']['humanized'];
				}
				return $result;
			case 'frequencies':
				$query['office_id'] = Gift::officeId();
				$conditions = array();
				if (!empty($query['office_id'])) {
					$conditions['FrequenciesOffice.office_id'] = $query['office_id'];
				}

				$frequencies = ClassRegistry::init('FrequenciesOffice')->find('all', array(
					'conditions' => $conditions,
					'contain' => array('Frequency(name, id, humanized)'),
					'order' => array('Frequency._order' => 'asc')
				));
				$result = array();
				foreach ($frequencies as $f) {
					$result[$f['Frequency']['id']] = $f['Frequency']['humanized'];
				}
				return $result;
			case 'amounts':
				$query['office_id'] = Gift::officeId();
				$amounts = '5,10,15';
				if (!isset($query['options']) && !empty($query['office_id'])) {
					$amounts = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['office_id']),
						'fields' => array('amounts')
					));
					$amounts = $amounts['Office']['amounts'];
				}
				return $amounts;
			case 'min_amount':
				$amounts = Gift::find('amounts', $query);
				return $amounts[0];
			case 'currencies':
				$query['office_id'] = Gift::officeId();
				$conditions = array();
				if (!empty($query['office_id'])) {
					$conditions['CurrenciesOffice.office_id'] = $query['office_id'];
				}

				$currencies = ClassRegistry::init('CurrenciesOffice')->find('all', array(
					'conditions' => $conditions,
					'contain' => array('Currency(iso_code, id)'),
					'order' => array('Currency.iso_code' => 'asc')
				));
				return Set::combine($currencies, '/Currency/id', '/Currency/iso_code');
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function name($id) {
		// !! form double submission depends on this so dont remove the created date!

		$gift = $this->find('first', array(
			'conditions' => array('Gift.id' => $id),
			'contain' => array('Contact(fname, lname)', 'GiftType(humanized)', 'Currency(iso_code)'),
			'fields' => array('Gift.gift_type_id', 'Gift.amount', 'Gift.created')
		));

		if (empty($gift)) {
			return false;
		}

		$name = sprintf('%s %s %s by %s %s on %s',
			$gift['Gift']['amount'],
			$gift['Currency']['iso_code'],
			$gift['GiftType']['humanized'],
			$gift['Contact']['fname'],
			$gift['Contact']['lname'],
			date('Y-m-d H:i', strtotime($gift['Gift']['created']))
		);
		$this->recursive = -1;
		return $this->updateAll(array('name' => '"' . $name . '"'), array('Gift.id' => $id));
	}
/**
 * undocumented function
 *
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($created) {
		return $this->name($this->id);
	}
/**
 * undocumented function
 *
 * @param string $gifts 
 * @return void
 * @access public
 */
	function softdelete($gifts) {
		return $this->updateAll(
			array(
				__CLASS__ . '.archived' => '"1"',
				__CLASS__ . '.archived_time' => '"' . date('Y-m-d H:i:s') . '"'
			),
			array('Gift.id' => Set::extract('/Gift/id', $gifts))
		);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @param string $status 
 * @return void
 * @access public
 */
	function updateStatus($id, $status) {
		$this->set(compact('id', 'status'));
		return $this->save(null, false);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function officeId() {
		$result = false;
		$isGuest = User::is('guest');

		$Session = Common::getComponent('Session');
		if ($Session->check('Office.id') && !$isGuest) {
			$result = $Session->read('Office.id');
		}
		if ($Session->check('gift_process_office_id') && $isGuest) {
			$result = $Session->read('gift_process_office_id');
		}
		return $result;

	}
}
?>