<?php
class Segment extends SegmentsAppModel {
	var $belongsTo = array('User');

	var $hasMany = array(
		'SegmentItem' => array(
			'className' => 'Segments.SegmentItem',
			'dependent' => true
		)
	);
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		$this->items = isset($this->data[__CLASS__]['items'])
						? explode(',', $this->data[__CLASS__]['items'])
						: false;
		$this->model = isset($this->data[__CLASS__]['model'])
						? $this->data[__CLASS__]['model']
						: false;

		return true;
	}
/**
 * undocumented function
 *
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($created) {
		if (empty($this->items)) {
			return true;
		}

		$currentItems = $this->SegmentItem->find('all', array(
			'conditions' => array('segment_id' => $this->id),
			'fields' => array('foreign_id')
		));
		$currentItems = Set::extract('/SegmentItem/foreign_id', $currentItems);

		foreach ($this->items as $itemId) {
			if (in_array($itemId, $currentItems)) {
				continue;
			}
			$this->SegmentItem->create(array(
				'segment_id' => $this->id,
				'foreign_id' => $itemId,
				'model' => $this->model
			));
			$this->SegmentItem->save();
		}
	}
}
?>