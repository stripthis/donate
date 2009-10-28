<?php
$title = 'Gifts ' . date('F Y', $startDate) . ' - ' . date('F Y', $endDate);


$createdValues = array();
$archivedValues = array();
$incompleteValues = array();
foreach ($result as $date => $gifts) {
	$archiveVal = 0;
	$incompleteValVal = 0;
	$createdVal = 0;
	foreach ($gifts as $gift) {
		if ($gift['Gift']['archived']) {
			$archiveVal++;
		}
		if (!$gift['Gift']['complete']) {
			$incompleteValVal++;
		}
		$createdVal++;
	}

	$createdValues[] = $createdVal;
	$archivedValues[] = $archiveVal;
	$incompleteValues[] = $incompleteValVal;
}

$labels = array_keys($result);
foreach ($labels as $i => $label) {
	$labels[$i] = date('m.y', strtotime($label));
}

$min = min($createdValues);
$max = max($createdValues);
$displayMin = $min > 2 ? $min - 3 : $min;

$chartOptions = array(
	'charts' => array(
		array(
			'key' => 'Created',
			'values' => $createdValues,
			'col' => '#66CC00',
			'outline' => '#006600'
		),
		array(
			'key' => 'Archived',
			'values' => $archivedValues,
			'col' => '#ff8800',
			'outline' => '#774499'
		),
		array(
			'key' => 'Incomplete',
			'values' => $incompleteValues,
			'col' => '#cc0000',
			'outline' => '#774499'
		)
	),
	'title' => array('txt' => $title),
	'x_axis' => compact('labels'),
	'y_axis' => array(
		'peaks' => array($displayMin, $max),
		'num_steps' => 10
	),
);

$chartOptions = array_merge_recursive(
	$chartOptions, Configure::read('Stats.defaultChartOptions')
);
echo $openFlashChart->build($chartOptions);
?>