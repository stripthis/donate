<?php
class Gift extends AppModel {
	var $actsAs = array(
		'Containable',
		'Lookupable',
		'Serialable',
		'ContinuousId' => array('offset' => '100000')
	);

	var $belongsTo = array(
		'Contact', 'User', 'Appeal', 'Office'
	);

	var $hasMany = array(
		'Transaction' => array('dependent' => true)
	);

	var $hasOne = array(
		'LastTransaction' => array(
			'className' => 'Transaction',
			'type' => 'left',
			'limit' => 1
		)
	);

	var $validate = array(
		'type' => array(
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
		'frequency' => array(
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
		$Session = Common::getComponent('Session');
		return array_key_exists(current($check), Gift::find('frequencies', array(
			'id' => $Session->read('gift_process_office_id')
		)));
	}
/**
 * Validate a gift type
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		$Session = Common::getComponent('Session');
		return array_key_exists($check['type'], Gift::find('gift_types', array(
			'id' => $Session->read('gift_process_office_id')
		)));
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
		$isGuest = User::is('guest');

		$args = func_get_args();
		switch ($type) {
			case 'gift_types':
				$frequencies = Configure::read('App.gift.types');

				$Session = Common::getComponent('Session');
				if ($Session->check('Office.id') && !$isGuest) {
					$query['id'] = $Session->read('Office.id');
				}
				if ($Session->check('gift_process_office_id') && $isGuest) {
					$query['id'] = $Session->read('gift_process_office_id');
				}

				if (!isset($query['options']) && isset($query['id'])) {
					$types = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
						'fields' => array('gift_types')
					));
					$types = explode(',', $types['Office']['gift_types']);
				}

				$result = array();
				foreach ($types as $type) {
					$result[$type] = Inflector::humanize($type);
				}
				return $result;
			case 'frequencies':
				$frequencies = Configure::read('App.gift.frequencies');

				$Session = Common::getComponent('Session');
				if ($Session->check('Office.id') && !$isGuest) {
					$query['id'] = $Session->read('Office.id');
				}
				if ($Session->check('gift_process_office_id') && $isGuest) {
					$query['id'] = $Session->read('gift_process_office_id');
				}

				if (!isset($query['options']) && isset($query['id'])) {
					$frequencies = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
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
				$Session = Common::getComponent('Session');
				if ($Session->check('Office.id') && !$isGuest) {
					$query['id'] = $Session->read('Office.id');
				}
				if ($Session->check('gift_process_office_id') && $isGuest) {
					$query['id'] = $Session->read('gift_process_office_id');
				}

				$amounts = '5,10,15';
				if (!isset($query['options']) && isset($query['id'])) {
					$amounts = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
						'fields' => array('amounts')
					));
					$amounts = $amounts['Office']['amounts'];
				}
				return $amounts;
			case 'min_amount':
				$amounts = Gift::find('amounts', $query);
				return $amounts[0];
			case 'currencies':
				$Session = Common::getComponent('Session');
				if ($Session->check('Office.id') && !$isGuest) {
					$query['id'] = $Session->read('Office.id');
				}
				if ($Session->check('gift_process_office_id') && $isGuest) {
					$query['id'] = $Session->read('gift_process_office_id');
				}

				$currencies = Configure::read('App.gift.currencies');
				if (isset($query['id'])) {
					$currencies = ClassRegistry::init('Office')->find('first', array(
						'conditions' => array('id' => $query['id']),
						'fields' => array('currencies')
					));
					$currencies = explode(',', $currencies['Office']['currencies']);
				}
				return $currencies;
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
/**
 * @todo: add currency support
 *
 * @access public
 */
	function name($id) {
		// !! form double submission depends on this so dont remove the created date!

		$gift = $this->find('first', array(
			'conditions' => array('Gift.id' => $id),
			'contain' => array('Contact(fname, lname)'),
			'fields' => array('Gift.type', 'Gift.amount', 'Gift.created')
		));

		if (empty($gift)) {
			return false;
		}

		$name = sprintf('%s %s by %s %s on %s',
			$gift['Gift']['amount'],
			$gift['Gift']['type'],
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
 */
	static function getFrequencies(){
		return Configure::read('App.gift.frequencies'); 
	}
/**
 * undocumented function
 */
	static function getCurrencies(){
		return Configure::read('App.gift.currencies'); 
	}
}
?>