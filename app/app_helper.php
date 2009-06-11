<?php
class AppHelper extends Helper {
	var $helpers = array('Session');
/**
 * undocumented function
 *
 * @param string $url 
 * @param string $full 
 * @return void
 * @access public
 */
	function url($url = null, $full = false) {
		$Router =& Router::getInstance();
		if (!empty($Router->__params)) {
			if (isset($Router) && !isset($Router->params['requested'])) {
				$params = $Router->__params[0];
			} else {
				$params = end($Router->__params);
			}
		}

		$lang = $this->Session->read('Config.language') . '/';

		if (isset($params['admin']) && $params['admin'] && !isset($url['admin'])) {
			$url['admin'] = $params['admin'];
		}

		if (is_array($url) && isset($url['controller']) && !isset($url['page'])) {
			if (!isset($url['action'])) {
				$url['action'] = 'index';
			}

			$admin = '';
			if (isset($url['admin']) && $url['admin']) {
				$admin = Configure::read('Routing.admin') . '/';
				if (strpos($url['action'], $admin . '_') === 0) {
					$url['action'] = substr($url['action'], strlen($admin));
				}
			}
			unset($url['admin']);
			unset($url['plugin']);

			$count = count($url);
			if (4 == $count) {
				return '/' . $lang . $admin . $url['controller'] . '/' . $url['action'] . '/' . $url[0] . '/' . $url[1];
			}

			if (3 == $count) {
				if (isset($url['id'])) {
					$url[0] = $url['id'];
				}
				return '/' . $lang. $admin . $url['controller'] . '/' . $url['action'] . '/' . $url[0];
			}

			if (2 == $count) {
				return '/' . $lang . $admin . $url['controller'] . '/' . $url['action'];
			}

			if (1 == $count) {
				return '/' . $lang . $admin . $url['controller'] . '/index';
			}
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