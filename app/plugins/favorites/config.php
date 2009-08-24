<?php
$config = array(
	'Favorites' => array(
		'subject' => 'starred item',
		'verb' => 'star',
		'adjective' => 'starred',
		'models' => array(
			'Gift' => 'name',
			'Transaction' => 'serial',
			'User' => 'login',
			'Comment' => 'increment'
		)
	)
);
?>