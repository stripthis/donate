<?php
$config = array(
	'Logging' => array(
		'models' => array(
			'Gift',
			'Transaction',
			'Import',
			'Export'
		),
		'urls' => array(
			'/\/admin\/.*$/'
		)
	)
);
?>