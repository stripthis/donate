<?php
class TemplateStep extends AppModel {
	var $belongsTo = array(
		'Template' => array(
			'counterCache' => true
		)
	);
}
?>