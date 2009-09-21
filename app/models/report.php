<?php
class Report extends AppModel {
	var $hasMany = array(
		'ReportsUser' => array(
			'dependent' => true
		)
	);
	var $hasAndBelongsToMany = array('User');
}
?>