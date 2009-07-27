<?php
class Comment extends AppModel {
	var $belongsTo = array(
		'User',
		'Gift' => array(
			'foreignKey' => 'foreign_id'
		)
	);
}
?>