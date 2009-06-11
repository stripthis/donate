<?php
class TimeZone extends AppModel {
	var $useTable = false;
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $validate = array(
		'name' => 'notEmpty'
	);
/**
 * Static function returning the current timestamp for any given $time_zone
 *
 * @param unknown $time_zone
 * @param unknown $gmt_time
 * @return void
 * @access public
 */
	static function time($timeZone, $when = 'now', $utcTime = null) {
		$offset = TimeZone::offset($timeZone, $when);
		if (empty($utcTime)) {
			 $utcTime = strtotime(gmdate('Y-m-d H:i:s'));
		}
		return $utcTime + $offset;
	}
/**
 * Returns timeZone offset in
 *
 * @param unknown $timeZone
 * @param unknown $when
 * @return void
 * @access public
 */
	static function offset($timeZone, $when = 'now') {
		try {
			$DateTimeZone = new DateTimeZone($timeZone);
			$DateTime = new DateTime($when, $DateTimeZone);
			$offset = (int)$DateTimeZone->getOffset($DateTime);
		} catch (Exception $Exception) {
			throw new AppException($Exception->getMessage());
		}
		Assert::isInteger($offset);
		return $offset;
	}
/**
 * undocumented function
 *
 * @param unknown $format
 * @param unknown $timeZone
 * @param unknown $when
 * @return void
 * @access public
 */
	static function date($format, $timeZone, $when = 'now') {
		try {
			$DateTimeZone = new DateTimeZone($timeZone);
			$DateTime = new DateTime($when, $DateTimeZone);
			$date = $DateTime->format($format);
		} catch (Exception $Exception) {
			throw new AppException($Exception->getMessage());
		}
		Assert::notEmpty($date);
		return $date;
	}
/**
 * undocumented function
 *
 * @param unknown $groups
 * @param unknown $includeOffset
 * @return void
 * @access public
 */
	static function listByGroups($groups = array(), $includeOffset = true) {
		if (empty($groups)) {
			$groups = TimeZone::listGroups();
		}

		$allZones = DateTimeZone::listIdentifiers();
		$listZones = array();

		foreach ($allZones as $zone) {
			@list($group, $city) = explode('/', $zone);
			if (!in_array($group, $groups)) {

			} elseif ($includeOffset) {
				$offset = TimeZone::offset($zone);
				$sign = $offset < 0
					? '-'
					: '+';
				$offset = date('H:i', mktime(0, 0, abs($offset)));
				$listZones[$group][] = $city.' (GMT '.$sign.$offset.')';
			}
		}

		foreach ($listZones as $group => $data) {
			$listZones[$group] = array_unique($listZones[$group]);
		}

		return $listZones;
	}
/**
 * undocumented
 *
 * @access public
 */
	static function listGroups($keys = false) {
		$groups = array(
			'Africa'
			, 'America'
			, 'Antarctica'
			, 'Arctic'
			, 'Asia'
			, 'Atlantic'
			, 'Australia'
			, 'Europe'
			, 'Indian'
			, 'Pacific'
		);

		if (!$keys) {
			return $groups;
		}
		return array_combine($groups, $groups);
	}
}