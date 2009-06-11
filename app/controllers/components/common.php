<?php

/**
 * This class serves as a namespace for functions that need to be globally available within this application.
 * All of it's functions can be called statically, i.e. Common::defaultTo(...), etc.
 *
 * @package default
 * @access public
 */
class Common extends Object
{
/**
 * undocumented
 *
 * @access public
 */
	function &getModel($model) {
		$modelClass = Inflector::camelize($model);
		if (!class_exists($modelClass) && !loadModel($modelClass)) {
			$tmp = false;
			return $tmp;
		}

		$modelKey = Inflector::underscore($modelClass);
		if (ClassRegistry::isKeySet($modelKey)) {
			$ModelObj =& ClassRegistry::getObject($modelKey);
		} else {
			$ModelObj =& new $modelClass();
			ClassRegistry::addObject($modelKey, $ModelObj);
		}
		return $ModelObj;
	}
/**
 * undocumented
 *
 * @access public
 */
	function &getComponent($component) {
		$componentKey = 'Component.'.$component;
		if (ClassRegistry::isKeySet($componentKey)) {
			$Component =& ClassRegistry::getObject($componentKey);
		} else {
			Assert::true(App::import('Component', $component));
			$class = $component.'Component';
			$Component = new $class;
			$Controller = new Controller();
			$Component->initialize($Controller, array());
			$Component->startup($Controller);
		}
		Assert::isObject($Component);
		return $Component;
	}
/**
 * undocumented function
 *
 * @param unknown $variable
 * @param unknown $defaultValue
 * @return void
 * @access public
 */
	function defaultTo(&$variable, $defaultValue) {
		if (func_num_args() == 3) {
			$empty = ($variable === func_get_arg(2));
		} else {
			$empty = empty($variable);
		}
		if ($empty == true) {
			return $variable = $defaultValue;
		}
		return $variable;
	}
/**
 * Works just like php's date() function, but $now will default to UTC+0 time instead of
 * the servers
 *
 * @param unknown $format
 * @param unknown $now
 * @return void
 * @access public
 */
	function utcDate($format, $now = null) {
		Common::defaultTo($now, Common::utcTime(), null);
		return date($format, $now);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function utcTime() {
		return strtotime(gmdate('Y-m-d H:i:s'));
	}
/**
 * Finds the unix time stamp for 00:00:00 of the $firstDayOfTheWeek of the week that $date
 * is in.
 *
 * @param unknown $date
 * @param unknown $firstDayOfTheWeek
 * @return void
 * @access public
 */
	function getWeekStart($date = null, $firstDayOfTheWeek = 'Monday') {
		if (!is_numeric($date)) {
			$date = strtotime($date);
		}

		$date = mktime(0, 0, 0, date('m', $date), date('d', $date), date('Y', $date));
		$daysMap = array(
			'Sunday'
			, 'Monday'
			, 'Tuesday'
			, 'Wednesday'
			, 'Thursday'
			, 'Friday'
			, 'Saturday'
		);

		$firstDayOfTheWeek = array_search($firstDayOfTheWeek, $daysMap);
		$offset = (date('w', $date) + 7 - $firstDayOfTheWeek) % 7;
		return strtotime('-'.$offset.' days', $date);
	}
/**
 * Finds the day number of the last day of the month
 *
 * @param unknown $date
 * @return void
 * @access public
 */
	function getMonthEnd($date = null) {
		if (!is_numeric($date)) {
			$date = strtotime($date);
		}

		$date = mktime(0, 0, 0, date('m', $date), date('d', $date), date('Y', $date));

		$month = date('m', $date);
		$year = date('Y', $date);
		for ($day = 28; $day < 33; $day++) {
			if (!checkdate($month, $day, $year)) {
				return $day-1;
			}
		}
	}
/**
 * undocumented function
 *
 * @param unknown $object
 * @param unknown $property
 * @param unknown $rules
 * @param unknown $default
 * @return void
 * @access public
 */
	function requestAllowed($object, $property, $rules, $default = false) {
		$allowed = $default;

		preg_match_all('/\s?([^:,]+):([^,:]+)/is', $rules, $matches, PREG_SET_ORDER);

		foreach ($matches as $match) {
			list($rawMatch, $allowedObject, $allowedProperty) = $match;
			$rawMatch = trim($rawMatch);
			$allowedObject = trim($allowedObject);
			$allowedProperty = trim($allowedProperty);
			$allowedObject = r('*', '.*', $allowedObject);
			$allowedProperty = r('*', '.*', $allowedProperty);

			$negativeCondition = false;
			if (substr($allowedObject, 0, 1) == '!') {
				$allowedObject = substr($allowedObject, 1);
				$negativeCondition = true;
			}

			if (preg_match('/^'.$allowedObject.'$/i', $object) && preg_match('/^'.$allowedProperty.'$/i', $property)) {
				$allowed = !$negativeCondition;
			}
		}
		return $allowed;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function gitVersion() {
		static $version = null;
		if (!is_null($version)) {
			return $version;
		}

		$versFile = ROOT. DS . '.git' . DS . 'refs' . DS . 'heads' . DS . 'master';
		if (!file_exists($versFile)) {
			return -1;
		}

		preg_match('/^[a-z0-9]+/', file_get_contents($versFile), $match);
		return $match[0];
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function recursiveMakehash($data) {
		if (!is_array($data)) {
			return $data;
		}

		$hash = '';
		foreach ($data as $key => $val) {
			$hash .= sprintf('%08X%08X', crc32($key), crc32(Common::recursiveMakehash($val)));
		}
		return $hash;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function arrayUniqueRecursive($array) {
		$hashes = array();
		foreach($array as $key => $val) {
			$hashes[$key] = Common::recursiveMakehash($val);
		}

		$hashes = array_unique($hashes);
		$result = array();
		foreach($hashes as $key => $val) {
			$result[$key] = $array[$key];
		}
		return $result;
	}

/**
 * undocumented function
 *
 * @param unknown $Object
 * @param unknown $properties
 * @return void
 * @access public
 */
	static function setProperties($Object, $properties) {
		Assert::isObject($Object);
		Assert::isArray($properties);
		foreach ($properties as $key => $val) {
			$Object->{$key} = $val;
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function mobileDevice() {
		if (preg_match('/iPhone/i', env('HTTP_USER_AGENT'))) {
			return 'iPhone';
		}
		return false;
	}
/**
* undocumented function
*
* @return void
* @access public
*/
	static function isLocalRequest() {
		return env('REMOTE_ADDR') == '127.0.0.1';
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function linkResources($contents, $conditionId = null, $ratings = false) {
		if (preg_match_all('/<a([^<>]*)href=["\']\[([A-Z]+):([A-Z0-9\-]+)\]["\']([^<>]*)>/si', $contents, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				if (!empty($conditionId) && $ratings === true) {
					$url = "/conditions/treatment_ratings/$conditionId/$match[3]";
				} else {
					$url = Common::resourceUrl($match[2], $match[3]);
				}
				if (!empty($url)) {
					$contents = str_replace($match[0], '<a' . $match[1] . 'class="ratings_view" ' . 'href="' . $url . '"' . $match[4] . '>', $contents);
				}
			}
		}

		return $contents;
	}
/**
 * undocumented function
 *
 * @return void
 * @author Felix
 */
	static function resourceUrl($resource, $id = null) {
		if ($resource{0} == '/') {
			return $resource;
		}
		if (strpos($resource, ':') > 0) {
			list($resource, $id) = explode(':', $resource);
		}
		if (!class_exists($resource) && !App::import('Model', $resource)) {
			return false;
		}
		return call_user_func(array($resource, 'url'), $id);
	}
/**
 * undocumented function
 *
 * @param string $str
 * @return void
 * @access public
 */
	function urlize($str) {
		if (empty($str)) {
			return '';
		}

		$str = trim($str);
		$str = r(
			array('#', '/', '&', ':', '?', '\'', '"', '(', ')', '+'),
			array(
				'-dash-', '--', '-ampersand-', 'colon', 'questionmark', 'quote',
				'doublequote', 'openingParenthesis', 'closingParenthesis', 'plussign'
			), $str
		);
		$str = urlencode($str);
		return $str;
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function urlUuid($id) {
		return substr($id, 0, 8) . '-' . substr($id, 8, 4) . '-' . substr($id, 12, 4) . '-' . substr($id, 16, 4) . '-';
	}
/**
 * undocumented function
 *
 * @param string $str
 * @return void
 * @access public
 */
	function deurlize($str) {
		if (empty($str)) {
			return '';
		}
		$str = urldecode($str);
		$str = r(
			array(
				'-dash-', '--', '-ampersand-', 'colon', 'questionmark', 'quote', 
				'doublequote', 'openingParenthesis', 'closingParenthesis', '-apos-',
				'plussign'
			),
			array('#', '/', '&', ':', '?', '\'',
			'"', '(', ')', '\'',
			'+'),
			$str
		);
		return $str;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function extract($regex, $str, $index = 0) {
		if (!preg_match($regex, $str, $match)) {
			return false;
		}
		return $match[$index];
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isUuid($str) {
		return is_string($str) && preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $str);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isProduction() {
		$domain = r('http://', '', Configure::read('App.domain'));
		$domain = r('staging.', '', $domain);
		$host = r('www.', '', env('HTTP_HOST'));
		return strpos($host, $domain) === 0;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isStaging() {
		$domain = r('http://', '', Configure::read('App.stagingDomain'));
		$domain = r('www.', '', $domain);
		$domain = r('staging.', '', $domain);
		$host = r('www.', '', env('HTTP_HOST'));
		return strpos($host, $domain) !== false;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function isDevelopment() {
		$domain = r('http://', '', Configure::read('App.domain'));
		$domain = r('www.', '', $domain);
		$domain = r('staging.', '', $domain);
		$host = r('www.', '', env('HTTP_HOST'));
		return !Common::isProduction() && !Common::isStaging()
				|| strpos($host, 'localcoolit') !== false
				|| strpos($host, 'dev.' . $domain) !== false;
	}
	
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	static function substitue($regex, $text) {
		preg_match_all($regex, $text, $matches);
		if (empty($matches[0])) {
			return array($text, array(), array());
		}
		$r = array();
		foreach ($matches[0] as $match) {
			$uuid = String::uuid();
			$r[1][] = $uuid;
			$r[2][] = $match;
			$text = r($match, $uuid, $text);
		}
		$r[0] = $text;
		return $r;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function debugEmail() {
		$Session = Common::getComponent('Session');
		prd($Session->read('Message.email'));
	}
/**
 * undocumented function
 *
 * @param string $path
 * @param string $pattern
 * @return void
 * @access public
 */
	function deleteFilesInDir($path, $pattern = '.*') {
		$pattern = '/'.$pattern.'/';
		$deletedOne = false;
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if ($file == '.' || $file == '..') {
					continue;
				}

				if (preg_match($pattern, $file)) {
					@unlink($path . DS . $file);
					$deletedOne = true;
				}
			}
		    closedir($handle);
		}
		return $deletedOne;
	}
/**
 * undocumented function
 *
 * @param string $length
 * @param string $whitelist
 * @return void
 * @access public
 */
	function randomString($length = 6, $whitelist = array()) {
		if ($length < 1) {
			trigger_error('Common::randomString() may not be called with a length < 1');
		}

		if (empty($whitelist)) {
			$whitelist = range(0, 9);
		}

		$result = '';
		for ($i = 0; $i < $length; $i++) {
			shuffle($whitelist);
			$result .= $whitelist[0];
		}

		return $result;
	}
}
?>