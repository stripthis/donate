<?php
class SmileyHelper extends Helper {
	var $helpers = array('Html', 'Session');
/**
 * undocumented function
 *
 * @param string $txt 
 * @param string $smileys 
 * @return void
 * @access public
 */
	function parse($txt, $smileys) {
		if (empty($smileys) || empty($txt)) {
			return $txt;
		}

		foreach ($smileys as $code => $img) {
			$img = '<img src="/files/plugins/smileys/' . $img . '" />';
			$txt = r($code, $img, $txt);
		}
		return $txt;
	}
}
?>