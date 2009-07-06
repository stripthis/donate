<?php
class Transaction extends AppModel {
	var $belongsTo = array(
		'Gateway',
		'Gift',
		'Parent' => array(
			'className' => 'Transaction',
			'foreignKey' => 'parent_id'
		)
	);
}
?>