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
			case 'by_office':
				$officeId = isset($query['office_id']) ? $query['office_id'] : false;

				$appeal = false;
				if ($officeId) {
					$appeal = $this->find('first', array(
						'conditions' => array(
							'OR' => array(
								'Appeal.office_id' => $officeId,
								'Appeal.campaign_code' => $officeId,
								'Appeal.name' => $officeId, //@todo use proper label instead of name (cf. ' ')
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
}
?>