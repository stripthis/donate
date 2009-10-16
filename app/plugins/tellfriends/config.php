<?php
App::import('Model');
$Session = Common::getComponent('Session');
$config = array(
	'Tellfriends' => array(
		'urls' => array(
			'/\/[^admin]+\/.*$/'
		)
	)
);
?>