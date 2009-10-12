<?php
class TemplateStepVisit extends AppModel {
	var $belongsTo = array(
		'TemplateStep' => array(
			'counterCache' => true
		)
	);
/**
 * undocumented function
 *
 * @param string $templateId 
 * @param string $step 
 * @return void
 * @access public
 */
	function trackHit($templateId, $appealId, $step) {
		$conditions = array(
			'template_id' => $templateId,
			'is_thanks' => '1'
		);
		if ($step != 'thanks') {
			unset($conditions['is_thanks']);
			$conditions['num'] = $step;
		}

		$step = $this->TemplateStep->find('first', array(
			'conditions' => $conditions,
			'fields' => array('id')
		));
		$stepId = $step['TemplateStep']['id'];


		$isPageview = false;

		$RequestHandler = Common::getComponent('RequestHandler');
		$ip = $RequestHandler->getClientIp();
		$date = date('Y-m-d H:i:s', strtotime('-1 hours'));

		$visit = $this->find('first', array(
			'conditions' => array(
				'template_step_id' => $stepId,
				'foreign_id' => $appealId,
				'ip' => $ip,
				"DATE_FORMAT(" . __CLASS__ . ".created, '%Y-%m-%d %H:%i:%s') >= '" . $date . "'"
			),
			'fields' => array('id', 'pageviews')
		));
		if (!empty($visit)) {
			$this->set(array(
				'id' => $visit[__CLASS__]['id'],
				'pageviews' => $visit[__CLASS__]['pageviews'] + 1
			));
		} else {
			$this->create(array(
				'template_step_id' => $stepId,
				'foreign_id' => $appealId,
				'ip' => $ip,
				'pageviews' => '1'
			));
		}
		return $this->save();
	}
}
?>