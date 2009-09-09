<?php
class GridFilterComponent extends Object {
/**
 * undocumented function
 *
 * @param string $condtiions 
 * @param string $params 
 * @param string $model 
 * @param string $field 
 * @return void
 * @access public
 */
	function dateRange($condtitions, &$params, $model, $field) {
		if (!empty($params['start_date_year'])) {
			if (empty($params['start_date_month'])) {
				$params['start_date_month'] = '01';
			}
			if (empty($params['start_date_day'])) {
				$params['start_date_day'] = '01';
			}
			$startDate = $params['start_date_year'] . '-' . $params['start_date_month'] . '-' . $params['start_date_day'];
			$condtitions[] = "DATE_FORMAT(" . $model . "." . $field. ", '%Y-%m-%d') >= '" . $startDate . "'";
		}

		if (!empty($params['end_date_year'])) {
			if (empty($params['end_date_month'])) {
				$params['end_date_month'] = '01';
			}
			if (empty($params['end_date_day'])) {
				$params['end_date_day'] = '01';
			}
			$endDate = $params['end_date_year'] . '-' . $params['end_date_month'] . '-' . $params['end_date_day'];
			$condtitions[] = "DATE_FORMAT(" . $model . "." . $field. ", '%Y-%m-%d') <= '" . $endDate . "'";
		}

		return $condtitions;
	}
}
?>