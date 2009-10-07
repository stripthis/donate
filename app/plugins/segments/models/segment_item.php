<?php
class SegmentItem extends SegmentsAppModel {
	var $belongsTo = array(
		'Segment' => array(
			'className' => 'Segments.Segment',
			'counterCache' => true
		)
	);
}
?>