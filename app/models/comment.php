<?php
class Comment extends AppModel {
	var $belongsTo = array(
		'User',
		'Post' => array(
			'foreignKey' => 'foreign_id'
		)
	);
}
?>