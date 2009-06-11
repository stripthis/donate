<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-04-19 10:04:01 : 1240130701*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'login' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'active' => array('type'=>'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'login'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'active'  => 1,
		'created'  => '2009-04-19 10:45:01',
		'modified'  => '2009-04-19 10:45:01'
	));
}
?>