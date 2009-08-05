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
	function getAppeal($appeal){
		$currentAppeal = null;
		if (isset($appealCode)) {
			$currentAppeal = $this->find('first', array(
				'conditions' => array(
					'OR' => array(
						'Appeal.id' => $appealCode,
						'Appeal.campaign_code' => $appealCode,
						'Appeal.name' => $appealCode //@todo use proper label instead of name (cf. ' ')
					)),
				'contain' => array("Office")
			));
		}
		// appeal not found use the default one
		if ($currentAppeal == null) {
			$currentAppeal = $this->find('first', array(
				'conditions' => array('default' => 1),
				'contain' => array("Office")
			));
		}
		return $currentAppeal;
	}
}
?>