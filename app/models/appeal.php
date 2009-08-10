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
			case 'concrete_or_default':
				$id = isset($query['id']) ? $query['id'] : false;

				$conditions = array('Appeal.default' => '1');
				if ($id) {
					$conditions = array(
						'OR' => array(
							'Appeal.id' => $id,
							'Appeal.campaign_code' => $id,
							'Appeal.name' => $id //@todo use proper label instead of name (cf. ' ')
						)
					);
				}

				return $currentAppeal = $this->find('first', array(
					'conditions' => $conditions,
					'contain' => array('Office')
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>