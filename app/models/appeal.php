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

	var $hasMany = array(
		'AppealStep' => array(
			'dependent' => true
		)
	);

	var $actsAs = array('Containable', 'Lookupabable', 'Enumerable');
/**
 * Get appeal from id, campaign_code or name
 * @param $appeal
 * @return unknown_type
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'default':
				$id = isset($query['id']) ? $query['id'] : false;

				$admin = User::isAdmin();
				$appeal = false;

				if ($id) {
					$conditions = array(
						'OR' => array(
							'Appeal.id' => $id,
							'Appeal.campaign_code' => $id,
							'Appeal.name' => $id, //@todo use proper label instead of name (cf. ' ')
						),
						'default' => '0',
						'admin' => $admin,
						'status <>' => 'archived'
					);
					if (!User::isAdmin()) {
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
						'status' => 'published',
						'admin' => $admin
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
	function afterSave() {
		if (isset($this->data['Appeal']['steps'])) {
			$this->AppealStep->deleteAll(array('appeal_id' => $this->id));
			$i = 0;
			foreach ($this->data['Appeal']['steps'] as $name) {
				if (empty($name)) {
					continue;
				}
				$i++;
				$this->AppealStep->create(array(
					'appeal_id' => $this->id,
					'num' => $i,
					'name' => $name
				));
				$this->AppealStep->save();
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