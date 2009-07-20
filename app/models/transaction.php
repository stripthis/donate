<?php
class Transaction extends AppModel {
	var $belongsTo = array(
		'Gateway',
		'Gift',
		'ParentTransaction' => array(
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
			),
			'contain' => false
		));
		if (empty($transaction)) {
			return 'invalid';
		}
		return true;
	}
}
?>