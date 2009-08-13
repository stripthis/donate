<?php
class Office extends AppModel {
	var $belongsTo = array(
		'ParentOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasMany = array(
		'SubOffice' => array(
			'className' => 'Office',
			'foreignKey' => 'parent_id'
		)
	);

	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewayOffice'
		)
	);
}
?>