<?php
class Appeal extends AppModel {
	var $belongsTo = array(
		'User',
		'Country',
		'Office',
		'Parent' => array(
			'className' => 'Appeal',
			'foreignKey' => 'parent_id'
		)
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
				$id = isset($query['id']) ? $query['id'] : false;

				$appeal = false;
				if ($id) {
					$appeal = $this->find('first', array(
						'conditions' => array(
							'OR' => array(
								'Appeal.id' => $id,
								'Appeal.campaign_code' => $id,
								'Appeal.name' => $id, //@todo use proper label instead of name (cf. ' ')
							),
							'default' => '0'
						),
						'contain' => array('Office')
					));
				}

				if (empty($appeal)) {
					$appeal = $this->find('first', array(
						'conditions' => array('Appeal.default' => '1'),
						'contain' => array('Office')
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