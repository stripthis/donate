<?php
class DateComponent extends Object {
/**
 * undocumented function
 *
 * @param string $date1 
 * @param string $date2 
 * @return void
 * @access public
 */
	static function same($date1, $date2, $type = 'month') {
		$format = 'Y-m';
		switch ($type) {
			case 'day':
				$format = 'Y-m-d';
				break;
			case 'hour':
				$format = 'Y-m-d H:00';
				break;
		}
		return date($format, strtotime($date1)) == date($format, strtotime($date2));
	}
/**
 * undocumented function
 *
 * @param string $startDate 
 * @param string $endDate 
 * @return void
 * @access public
 */
	static function diff($type, $startDate, $endDate, $count = true) {
		if ($count) {
			$map = array(
				'hour' => HOUR,
				'day' => DAY,
				'month' => MONTH,
				'year' => YEAR
			);
			return (strtotime($endDate) - strtotime($startDate)) / $map[$type];
		}

		$format = 'Y-m-d';
		if ($type == 'hour') {
			$format = 'Y-m-d H:00';
			$startDate = date($format, strtotime($startDate));
		}

		$startStamp = strtotime($startDate);
		$endStamp = strtotime($endDate);
		if ($startStamp >= $endStamp) {
			return array();
		}

		$endDate = date($format, $endStamp);

		$items = array();
		$i = 0;

		$reachedEnd = false;
		while (!$reachedEnd) {
			$s = '+' . $i . ' ' . $type . 's';
			$item = date($format, strtotime($s, $startStamp));
			$items[] = $item;
			if ($item == $endDate) {
				break;
			}
			$i++;
		}
		return $items;
	}
}
?>