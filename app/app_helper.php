<?php
class AppHelper extends Helper {
/**
 * undocumented function
 *
 * @param string $url 
 * @param string $full 
 * @return void
 * @access public
 */
	function url($url = null, $full = false) {
		if (!isset($url['plugin'])) {
			$url['plugin'] = '';
		}
		return parent::url($url, $full);
	}
/**
 * undocumented function
 *
 * @param string $options 
 * @param string $exclude 
 * @param string $insertBefore 
 * @param string $insertAfter 
 * @return void
 * @access public
 */
	function _parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		if (is_array($options)) {
			$options = array_merge(array('escape' => false), $options);
			if (!is_array($exclude)) {
				$exclude = array();
			}
			$keys = array_diff(array_keys($options), array_merge((array)$exclude, array('escape')));
			$values = array_intersect_key(array_values($options), $keys);
			$escape = $options['escape'];
			$attributes = array();

			foreach ($keys as $index => $key) {
				$attributes[] = $this->__formatAttribute($key, $values[$index], $escape);
			}
			$out = implode(' ', $attributes);
		} else {
			$out = $options;
		}

		return $out ? $insertBefore . $out . $insertAfter : '';
	}
}
?>