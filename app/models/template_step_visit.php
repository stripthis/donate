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
		$stepId = false;
		if ($step == 'thanks') {
			$lastStep = $this->TemplateStep->find('first', array(
				'conditions' => array('template_id' => $templateId),
				'order' => array('num' => 'desc'),
				'fields' => array('id')
			));
			$stepId = $lastStep['TemplateStep']['id'];
		} else {
			$step = $this->TemplateStep->find('first', array(
				'conditions' => array(
					'template_id' => $templateId,
					'num' => $step
				),
				'fields' => array('id')
			));
			$stepId = $step['TemplateStep']['id'];
		}

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