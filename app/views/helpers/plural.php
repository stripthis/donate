<?php
class PluralHelper extends Helper {
	function ize($string, $count, $showCount = true) {
		if ($count != 1) {
			$inflect = new Inflector();
			return ($showCount ? $count . ' ' : '') . $inflect->pluralize($string);
		}

		return ($showCount ? $count . ' ' : '') . $string;
	}
}
?>