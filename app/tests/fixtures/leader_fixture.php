<?php 
/* SVN FILE: $Id$ */
/* Leader Fixture generated on: 2009-04-08 12:04:03 : 1239185043*/

class LeaderFixture extends CakeTestFixture {
	var $name = 'Leader';
	var $table = 'leaders';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 3, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'company' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 0), 'company' => array('column' => 'company', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'company'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-04-08 12:04:03',
		'modified'  => '2009-04-08 12:04:03'
	));
}
?>