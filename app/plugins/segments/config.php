<?php
$config = array(
	'Segments' => array(
		'models' => array(
			'Gift',
			'Transaction'
		),
		'contain' => array(
			'Gift.Contact',
			'Gift.Frequency',
			'Transaction.Gateway'
		),
		'urls' => array(
			'/\/admin\/.*$/'
		)
	)
);
?>