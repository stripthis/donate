<?php
class Post extends AppModel {
	var $hasMany = array(
		'Comment' => array(
			'foreignKey' => 'foreign_id'
		)
	);
}
?>