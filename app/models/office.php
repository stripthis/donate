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
		),
		'GatewaysOffice' => array(
			'dependent' => true
		)
	);

	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewaysOffice'
		)
	);

	var $validate = array(
		'frequencies' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify at least one frequency option!',
				'required' => true,
				'last' => true
			)
		),
		'amounts' => array(
			'required' => array(
				'rule' => array('validateAmounts'),
				'message' => 'Please specify valid amount options!',
				'required' => true,
				'last' => true
			),
		),
	);
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		$this->data['Office']['amounts'] = r(' ', '', $this->data['Office']['amounts']);

		$this->GatewaysOffice->deleteAll(array('office_id' => $this->id));
		if (!empty($this->data['Office']['gateways'][0])) {
			foreach ($this->data['Office']['gateways'] as $gatewayId) {
				$this->GatewaysOffice->create(array(
					'office_id' => $this->id,
					'gateway_id' => $gatewayId
				));
				$this->GatewaysOffice->save();
			}
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeValidate() {
		if (empty($this->data['Office']['frequencies'])) {
			$this->data['Office']['frequencies'] = array();
		}
		$this->data['Office']['frequencies'] = implode(',', $this->data['Office']['frequencies']);
		return true;
	}
/**
 * Validate amount - to avoid small amounts
 * @param $check
 * @return unknown_type
 */
	function validateAmounts($check) {
		$check = explode(',', current($check));
		foreach ($check as $amount) {
			if (!is_numeric($amount)) {
				return false;
			}
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
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function activate($id) {
		if (is_array($id)) {
			$office = $id;
		} else {
			$office = $this->find('first', array(
				'conditions' => array('Office.id' => $id),
				'contain' => array('SubOffice', 'ParentOffice')
			));
		}

		if (isset($office['Office'])) {
			$newOffice = $office['Office'];
			$newOffice['ParentOffice'] = $office['ParentOffice'];
			$newOffice['SubOffice'] = $office['SubOffice'];
			$office = $newOffice;
		}

		$Session = Common::getComponent('Session');
		$Session->write('Office', $office);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function reload($id) {
		$Session = Common::getComponent('Session');
		if ($id == $Session->read('Office.id')) {
			$this->activate($id);
		}
	}
}
?>