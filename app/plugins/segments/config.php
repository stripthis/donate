<?php
$config = array(
	'Segments' => array(
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