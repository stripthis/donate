<?php
class Transaction extends AppModel {
	var $belongsTo = array(
		'Gateway',
		'Gift',
		'ParentTransaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'parent_id'
		)
	);
}
?>