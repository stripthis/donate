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

	var $hasMany = array(
		'ChildTransaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'parent_id'
		)
	);
/**
 * undocumented function
 *
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($created) {
		if ($created) {
			$this->serial($this->id, true);
		}
		return true;
	}
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
/**
 * undocumented function
 *
 * @param string $userId 
 * @param string $forceCreate 
 * @return void
 * @access public
 */
	function serial($id, $forceCreate = false) {
		App::import('Core', 'Security');
		if (!$forceCreate) {
			$key = $this->lookup(compact('id'), 'serial', false);
			if (!empty($key)) {
				return $key;
			}
		}

		do {
			$key = Security::generateAuthKey();
			$key = substr($key, 0, 5);
		} while (!$this->isUnique(array('serial' => $key)));

		$this->set(array(
			'id' => $id,
			'serial' => $key
		));
		$this->save();
		return $key;
	}
}
?>