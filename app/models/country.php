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
		$_this = ClassRegistry::init('Country');
		return $_this->lookup(array('name' => $name), 'id', false);
	}
}
?>