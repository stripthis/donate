<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'greenpeace_white_rabbit',
		'prefix' => '',
		'encoding' => 'utf8'
	);

	var $test = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'root',
		'database' => 'test_greenpeace_white_rabbit',
		'prefix' => '',
	);
}
?>