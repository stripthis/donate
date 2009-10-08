<?php
class SegmentsAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->SegmentItem = $this->Segment->SegmentItem;
		$models = Configure::read('Segments.models');
		foreach ($models as $model) {
			$Model = ClassRegistry::init($model);
			$this->SegmentItem->bindModel(
				array('belongsTo' => array(
					$model => array('foreignKey' => 'foreign_id')
				)),
				false
			);
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		$Segment = ClassRegistry::init('Segment');
		$segments = $Segment->find('all', array(
			'conditions' => array('user_id' => User::get('id')),
			'order' => array('Segment.name' => 'asc')
		));
		return compact('segments');
	}
}
?>