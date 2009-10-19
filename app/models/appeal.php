<?php
class Appeal extends AppModel {
	var $belongsTo = array(
		'User',
		'Office',
		'Parent' => array(
			'className' => 'Appeal',
			'foreignKey' => 'parent_id'
		),
		'CurrentTemplate' => array(
			'className' => 'Template',
			'foreignKey' => 'template_id'
		)
	);

	var $hasMany = array(
		'AppealsTheme' => array(
			'dependent' => true
		),
	);

	var $hasAndBelongsToMany = array(
		'Theme'
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
			'valid' => array(
				'rule' => 'money',
				'message' => 'This is not a monetary amount',
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
			'valid' => array(
				'rule' => 'money',
				'message' => 'This is not a monetary amount',
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
						'contain' => array('Office', 'CurrentTemplate')
					));
				}

				if (empty($appeal)) {
					$appeal = $this->find('first', array(
						'conditions' => array('Appeal.default' => '1'),
						'contain' => array('Office', 'CurrentTemplate'),
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
	function beforeValidate() {
		if (isset($this->data[__CLASS__]['default']) && $this->data[__CLASS__]['default']) {
			$Session = Common::getComponent('Session');
			$conditions = array(
				'default' => '1',
				'office_id' => $Session->read('Office.id')
			);
			if (!empty($this->data[__CLASS__]['id'])) {
				$conditions['id <>'] = $this->data[__CLASS__]['id'];
			}

			$defaultAppeal = $this->find('first', array(
				'conditions' => $conditions,
				'fields' => array('id', 'name')
			));
			if (!empty($defaultAppeal)) {
				$msg = sprintf(__('Sorry, there can only be one default appeal at the same time. 
							The current default appeal is: "%s".', true
						), $defaultAppeal[__CLASS__]['name']);
				$this->invalidate('default', $msg);
				return false;
			}
		}

		$published = isset($this->data[__CLASS__]['status']) && $this->data[__CLASS__]['status'];
		$templateId = false;
		if (isset($this->data[__CLASS__]['template_id'])) {
			$templateId = $this->data[__CLASS__]['template_id'];
		} elseif (isset($this->data[__CLASS__]['id'])) {
			$templateId = $this->lookup(
				array('id' => $this->data[__CLASS__]['id']), 'template_id', false
			);
		}
		$publishedTemplate = $this->Template->lookup(
			array('id' => $templateId), 'published', false
		);

		if (!$publishedTemplate) {
			$msg = __('You cannot set the status to "published" if there is no published template assigned.', true);
			$this->invalidate('status', $msg);
		}
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

		$monetaryFields = array('cost', 'targeted_income');
		foreach ($monetaryFields as $field) {
			if (isset($this->data[__CLASS__][$field])) {
				$this->data[__CLASS__][$field] = (float) r(',', '.', $this->data[__CLASS__][$field]);
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
	}
}
?>