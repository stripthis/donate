<?php
class Country extends AppModel{
	var $hasMany = array('State');
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function getIdByName($name = 'United States') {
		return ClassRegistry::init(__CLASS__)->lookup(
			array('name' => $name), 'id', false
		);
	}
}
?>