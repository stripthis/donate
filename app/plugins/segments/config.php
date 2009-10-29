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
			'Gift.GiftType',
			'Transaction.Gateway'
		),
		'urls' => array(
			'/\/admin\/.*$/'
		)
	)
);
?>