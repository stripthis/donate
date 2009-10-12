<?php
class Template extends AppModel {
	var $hasMany = array(
		'TemplateStep' => array(
			'dependent' => true
		),
		'AppealsTemplate' => array(
			'dependent' => true
		),
	);

	var $hasAndBelongsToMany = array(
		'Appeals'
	);
}
?>