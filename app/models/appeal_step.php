<?php
class AppealStep extends AppModel {
	var $belongsTo = array(
		'Appeal' => array(
			'counterCache' => true
		)
	);
}
?>