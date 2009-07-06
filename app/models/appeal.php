<?php
class Appeal extends AppModel {
	var $belongsTo = array(
		'User',
		'Country',
		'Parent' => array(
			'className' => 'Appeal',
			'foreignKey' => 'parent_id'
		)
	);
}
?>