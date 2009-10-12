<?php
class Appeal extends AppModel {
	var $belongsTo = array(
		'User',
		'Office',
		'Parent' => array(
			'className' => 'Appeal',
			'foreignKey' => 'parent_id'
		)
	);
	
	/* @todo moved to template
	var $hasMany = array(
		'AppealStep' => array(
			'dependent' => true
		)
	);*/

	var $hasMany = array(
		'AppealsTemplate' => array(
			'dependent' => true
		),
		'AppealsTheme' => array(
			'dependent' => true
		),
	);

	var $hasAndBelongsToMany = array(
		'Theme', 'Template'
	);

	var $actsAs = array(
		'Containable', 'Lookupable', 'Enumerable',
		'Sluggable' => array('label' => 'name')
	);

	var $validate = array(
		'name' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify a name!',
				'last' => true
			)
		),
		'cost' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify a cost!',
				'last' => true
			),
		),
		'campaign_code' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify a campaign code!',
				'last' => true
			),
		),
		'targeted_income' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify the targeted income!',
				'last' => true
			),
		),
		'targeted_signups' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please specify the number of targeted signups!',
				'last' => true
			),
		),

	);
/**
 * Get appeal from id, campaign_code or name
 * @param $appeal
 * @return unknown_type
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'default':
				$appeal = false;

				$id = isset($query['id']) ? $query['id'] : false;
				if ($id) {
					$conditions = array(
						'OR' => array(
							'Appeal.id' => $id,
							'Appeal.name' => $id,
							'Appeal.slug' => $id,
						),
						'default' => '0',
						'status <>' => 'archived'
					);
					if (User::is('guest')) {
						$conditions['status'] = 'published';
					}
					$appeal = $this->find('first', array(
						'conditions' => $conditions,
						'contain' => array('Office')
					));
				}

				if (empty($appeal)) {
					$appeal = $this->find('first', array(
						'conditions' => array('Appeal.default' => '1'),
						'contain' => array('Office'),
						'status' => 'published'
					));
				}
				return $appeal;
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		$this->themes = isset($this->data[__CLASS__]['themes'])
						? $this->data[__CLASS__]['themes']
						: false;
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function afterSave($created) {
		// if (isset($this->data['Appeal']['steps'])) {
		// 	$this->AppealStep->deleteAll(array('appeal_id' => $this->id));
		// 	$i = 0;
		// 	foreach ($this->data['Appeal']['steps'] as $name) {
		// 		if (empty($name)) {
		// 			continue;
		// 		}
		// 		$i++;
		// 		$this->AppealStep->create(array(
		// 			'appeal_id' => $this->id,
		// 			'num' => $i,
		// 			'name' => $name
		// 		));
		// 		$this->AppealStep->save();
		// 	}
		// }

		if ($this->themes !== false) {
			$this->AppealsTheme->deleteAll(array('appeal_id' => $this->id));
			foreach ($this->themes as $id => $val) {
				if (!$val) {
					continue;
				}
				$this->AppealsTheme->create(array(
					'appeal_id' => $this->id,
					'theme_id' => $id
				));
				$this->AppealsTheme->save();
			}
		}
		return true;

		// @todo: template management
		$id = $this->id;
		$appeal = $this->find('first', array(
			'conditions' => compact('id'),
		));
		$code = Inflector::underscore($appeal[__CLASS__]['campaign_code']);

		App::import('Core', 'Folder');
		$folder = new Folder(VIEWS . 'templates');
		$contents = $folder->read();

		$move = false;
		foreach ($contents[0] as $dir) {
			if (strpos($dir, $id) !== false) {
				$move = $dir;
				break;
			}
		}

		if ($created) {
			$path = VIEWS . 'templates' . DS . $code . '_' . $id;
			mkdir($path, 0755);

			$src = VIEWS . 'templates' . DS . 'default' . DS . 'step1.ctp';
			$dest = $path . DS . 'step1.ctp';
			copy($src, $dest);
			$src = VIEWS . 'templates' . DS . 'default' . DS . 'step2.ctp';
			$dest = $path . DS . 'step2.ctp';
			copy($src, $dest);
		} else {
			$oldPath = VIEWS . 'templates' . DS . $move;
			$folder = new Folder($oldPath);
			$folder->move(array(
				'to' => VIEWS . 'templates' . DS . $code . '_' . $id
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
	function afterDelete() {
		App::import('Core', 'Folder');
		$folder = new Folder(VIEWS . 'templates');
		$contents = $folder->read();
		$toDelete = false;
		foreach ($contents[0] as $dir) {
			if (strpos($dir, $this->id) !== false) {
				$toDelete = $dir;
				break;
			}
		}

		if ($toDelete) {
			$oldPath = VIEWS . 'templates' . DS . $toDelete;
			$folder = new Folder($oldPath);
			$folder->delete();
		}
		return true;
	}
}
?>