<?php
class Transaction extends AppModel {
	var $actsAs = array(
		'Containable', 'Lookupable', 'Serialable'
	);

	var $belongsTo = array(
		'Gateway',
		'Gift',
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
				'status' => 'new' // todo need 2 support more statuses based on error handling
			)
		));
		if (empty($transaction)) {
			return 'invalid';
		}
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
			array(__CLASS__ . '.archived' => '"1"'),
			array(__CLASS__ . '.id' => Set::extract('/' . __CLASS__ . '/id', $items))
		);
	}
}
?>