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
		),
		'CountriesOffice' => array(
			'dependent' => true
		),
		'Appeal' => array(
			'dependent' => true
		),
		'User'
	);

	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewaysOffice'
		),
		'Country' => array(
			'with' => 'CountriesOffice'
		),
	);

	var $validate = array(
		'frequencies' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify at least one frequency option!',
				'last' => true
			)
		),
		'amounts' => array(
			'required' => array(
				'rule' => array('validateAmounts'),
				'message' => 'Please specify valid amount options!',
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
		if (isset($this->data['Office']['amounts'])) {
			$this->data['Office']['amounts'] = r(' ', '', $this->data['Office']['amounts']);
		}

		if (isset($this->data['Office']['gateways'])) {
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
		}

		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function afterSave($created) {
		if (isset($this->data['Office']['permissions'])) {
			$permissions = Configure::read('App.permission_options');
			foreach ($this->data['Office']['permissions'] as $userId => $perms) {
				$diff = array_diff($permissions, $perms);
				if (empty($diff)) {
					continue;
				}

				$s = '';
				foreach ($diff as $perm) {
					$s .= '!' . $perm . ',';
				}
				$s = substr($s, 0, -1);

				$this->User->set(array(
					'id' => $userId,
					'permissions' => $s
				));
				$this->User->save();
			}
		}

		// create new appeal folder
		
		// do we have an appeal?
		$name = $this->data['Office']['name'] . ' Admin Appeal';
		$code = Inflector::underscore(r(' ', '', $name));

		$create = false;
		$move = false;

		$appeal = $this->Appeal->find('first', array(
			'conditions' => array(
				'office_id' => $this->id,
				'name LIKE' => '%Admin%'
			)
		));
		if (!empty($appeal)) {
			$appealId = $appeal['Appeal']['id'];
			App::import('Core', 'Folder');
			$folder = new Folder(VIEWS . 'templates');
			$contents = $folder->read();

			foreach ($contents[0] as $dir) {
				if (strpos($dir, $appealId) !== false) {
					$move = $dir;
					break;
				}
			}
			$create = !$move;
		} else {
			$this->Appeal->create(array(
				'name' => $name,
				'campaign_code' => $code,
				'office_id' => $this->id,
				'steps' => 1,
				'user_id' => User::get('id')
			));
			$this->Appeal->save();
			$appealId = $this->Appeal->getLastInsertId();
			$create = true;
		}

		if ($create) {
			$path = VIEWS . 'templates' . DS . $code . '_' . $appealId;
			mkdir($path, 0755);
			$src = VIEWS . 'templates' . DS . 'admin_default' . DS . 'step1.ctp';
			$dest = $path . DS . 'step1.ctp';
			copy($src, $dest);
		}
		if ($move) {
			$oldPath = VIEWS . 'templates' . DS . $move;
			$folder = new Folder($oldPath);
			$folder->move(array(
				'to' => VIEWS . 'templates' . DS . $code . '_' . $appealId
			));
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
			'fields' => array('id')
		));
		$isValidSubOffice = in_array($id, Set::extract('/Office/id', $subOffices));

		return $isValidSubOffice || $isMyOffice || User::isRoot();
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
				'contain' => array(
					'SubOffice', 'ParentOffice'
				)
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
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	public function subRelations($id, $data) {
		$this->updateAll(
			array('Office.parent_id' => "''"),
			array('Office.parent_id' => $id)
		);

		if (!is_array($data['Office']['suboffice_id'])) {
			return false;
		}

		foreach ($data['Office']['suboffice_id'] as $subOfficeId) {
			$this->id = $subOfficeId;
			$this->saveField('parent_id', $id);
		}
	}
}
?>