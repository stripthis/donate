<?php
class PluralHelper extends Helper {
/**
 * undocumented function
 *
 * @param string $string 
 * @param string $count 
 * @param string $showCount 
 * @return void
 * @access public
 */
	function ize($string, $count, $showCount = true) {
		if ($count != 1) {
			$inflect = new Inflector();
			return ($showCount ? $count . ' ' : '') . $inflect->pluralize($string);
		}
		return ($showCount ? $count . ' ' : '') . $string;
	}
}
?>