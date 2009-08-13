<?php
class Office extends AppModel {
	var $belongsTo = array(
		'ParentOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'SubOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewayOffice'
		)
	);
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	static function isOwn($id) {
		$isMyOffice = $id == User::get('office_id');

		// @todo: currently only 2 levels of recursion
		$_this = ClassRegistry::init(__CLASS__);
		$subOffices = $_this->find('all', array(
			'conditions' => array('parent_id' => User::get('office_id')),
			'contain' => false,
			'fields' => array('id')
		));
		$isValidSubOffice = in_array($id, Set::extract('/Office/id', $subOffices));

		return $isValidSubOffice || $isMyOffice;
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function parentOfficeOptions($id) {
		return $this->find('list', array(
			'conditions' => array(
				'id <>' => $id,
				'parent_id' => ''
			),
			'contain' => false
		));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function subOfficeOptions($id, $type = 'normal') {
		$subOffices = $this->find('list', array(
			'conditions' => array(
				'id <>' => $id,
				'parent_id' => array('', $id)
			),
			'contain' => false
		));

		$ids = array_keys($subOffices);
		if ($type == 'selected') {
			return $ids;
		}

		$subParentOffices = $this->find('all', array(
			'conditions' => array(
				'parent_id' => $ids
			),
			'contain' => false,
			'fields' => array('parent_id')
		));
		$ids = Set::extract('/Office/parent_id', $subParentOffices);

		foreach ($subOffices as $id => $name) {
			if (in_array($id, $ids)) {
				unset($subOffices[$id]);
			}
		}

		return $subOffices;
	}
}
?>