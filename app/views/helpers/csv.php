<?php
/**
 * Csv Helper
 * Copyright (c)  Debuggable, Ltd. 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Debuggable, Ltd.
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php  
 */
class CsvHelper extends Apphelper {
/**
 * undocumented function
 *
 * @param string $items 
 * @param string $delim 
 * @return void
 * @access public
 */
	function build($items, $delim = ';') {
		if (empty($items)) {
			return false;
		}
		$result = array();
		foreach ($items as $item) {
			$row = array();
			foreach ($item as $submodel => $data) {
				$row = am($row, $data);
			}
			$result[] = implode($delim, $row);
		}
		return implode("\n", $result);
	}
}
?>