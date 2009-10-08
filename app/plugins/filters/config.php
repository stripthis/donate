<?php
$config = array(
	'Filters' => array(
		'models' => array(
			'Gift',
			'Transaction'
		),
		'contain' => array(
			'Gift.Contact',
			'Transaction.Gateway'
		)
	)
);
?>