<?php
/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class SimpleTextileHelper extends Helper {
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $helpers = array(
		'Html'
	);
/**
 * Takes a simple textile $string and turns it into html.
 *
 * @param string $string A string containing simple textile that needs to be turned into html
 * @return string The html for the given textile $string
 */
	function toHtml($string) {
		$string = h($string);
		$string = r('&quot;', '"', $string);
	
		preg_match_all('/"(.+)"\:(.+)(\.\s|\.$|,\s|,$|\s|$)/iU', $string, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			list($raw, $linkText, $link, $ending) = $match;
			$textileLink = $raw;
			if (!empty($ending)) {
				$textileLink = substr($raw, 0, -strlen($ending));
			}
			$string = r($textileLink, $this->Html->link($linkText, $link), $string);
		}

		$string = preg_replace('/\*([^*]+)\*/is', '<strong>\\1</strong>', $string);
		$string = preg_replace('/\_([^*]+)\_/is', '<em>\\1</em>', $string);
		$string = nl2br($string);
		return $string;
	}
}
?>