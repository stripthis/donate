<?php
$config = array(
	'Comments' => array(
		'models' => array(
			// threaded?
			'Gift' => true,
			'User' => true,
			'Contact' => true
		),
		'urls' => array(
			'/\/admin\/gifts\/view\/.*$/'
		)
	)
);
?>