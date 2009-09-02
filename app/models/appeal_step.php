<?php
class AppealStep extends AppModel {
	var $belongsTo = array(
		'Appeal' => array(
			'counterCache' => true
		)
	);
/**
 * undocumented function
 *
 * @param string $appealId 
 * @param string $step 
 * @return void
 * @access public
 */
	function addVisit($appealId, $step) {
		$Session = Common::getComponent('Session');
		$sessKey = 'appeal_visits';
		if (!$Session->check($sessKey)) {
			$Session->write($sessKey, array());
		}

		$appealVisits = $Session->read($sessKey);
		$key = $appealId . '_' . $step;
		if (!in_array($key, $appealVisits)) {
			$appealStep = $this->find('first', array(
				'conditions' => array(
					'appeal_id' => $appealId,
					'num' => $step
				),
				'fields' => array('id', 'visits')
			));
			if (empty($appealStep)) {
				return false;
			}

			$this->set(array(
				'id' => $appealStep['AppealStep']['id'],
				'visits' => $appealStep['AppealStep']['visits'] + 1,
			));
			$this->save();

			$appealVisits[] = $key;
			$Session->write($sessKey, $appealVisits);
		}
	}
}
?>