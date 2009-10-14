<?php
class Export extends AppModel {
	var $actsAs = array(
		'Containable', 'Lookupable',
		'SavedBy' => array(
			'createdField' => 'created_by',
			'modifiedField' => false,
			'model' => 'User'
		)
	);

	var $belongsTo = array(
		'User' => array(
			'foreignKey' => 'created_by'
		)
	);
}
?>