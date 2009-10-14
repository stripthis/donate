<?php
class Export extends AppModel {
	var $belongsTo = array(
		'User' => array(
			'foreignKey' => 'created_by'
		)
	);
}
?>