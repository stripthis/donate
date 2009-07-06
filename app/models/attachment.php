<?php
class Attachment extends AppModel {
	var $belongsTo = array(
		'Comment' => array(
			'foreignKey' => 'foreign_id'
		),
		'Post' => array(
			'foreignKey' => 'foreign_id'
		)
	);
}
?>