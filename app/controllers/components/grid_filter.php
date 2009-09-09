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
	function dateRange($condtitions, $params, $model, $field) {
		if (!empty($params['start_date_year']) && !empty($params['start_date_month'])) {
			$startDate = '01-' . $params['start_date_month'] . '-' . $params['start_date_year'];
			$condtitions[] = "DATE_FORMAT(" . $model . "." . $field. ", '%Y-%m-%d') >= '" . $startDate . "'";
		}

		if (!empty($params['end_date_year']) && !empty($params['end_date_month'])) {
			$endDate = '01-' . $params['end_date_month'] . '-' . $params['end_date_year'];
			$condtitions[] = "DATE_FORMAT(" . $model . "." . $field. ", '%Y-%m-%d') <= '" . $endDate . "'";
		}

		return $condtitions;
	}
}
?>