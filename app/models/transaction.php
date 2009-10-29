<?php
class Transaction extends AppModel {
	var $actsAs = array(
		'Containable', 'Lookupable', 'Serialable'
	);

	var $belongsTo = array(
		'Gateway',
		'Import',
		'Gift',
		'Currency',
		'ParentTransaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'ChildTransaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'parent_id'
		)
	);
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function process($id) {
		$transaction = $this->find('first', array(
			'conditions' => array(
				$this->alias . '.id' => $id,
				'status' => 'new'
			)
		));
		if (empty($transaction)) {
			return 'invalid';
		}

		// bibitFake
		$Bibit = ClassRegistry::init('Bibitfake.Bibit');
		$result = $Bibit->process(array('tId' => $id));
		$this->set(array(
			'id' => $id,
			'order_id' => $result['order_id']
		));

		if (isset($result['url'])) {
			return $result['url'];
		}

		// for direct method update gift status as transaction status changes via Gift::updateStatus
		return true;
	}
/**
 * undocumented function
 *
 * @param string $gifts 
 * @return void
 * @access public
 */
	function softdelete($items) {
		return $this->updateAll(
			array(
				__CLASS__ . '.archived' => '"1"',
				__CLASS__ . '.archived_time' => '"' . date('Y-m-d H:i:s') . '"'
			),
			array(__CLASS__ . '.id' => Set::extract('/' . __CLASS__ . '/id', $items))
		);
	}
}
?>