<?php
$title = 'Gifts ' . date('F Y', $startDate) . ' - ' . date('F Y', $endDate);
$values = array();
foreach ($result as $date => $gifts) {
	$values[] = count($gifts);
}

$labels = array_keys($result);
foreach ($labels as $i => $label) {
	$labels[$i] = date('m.y', strtotime($label));
}

$min = min($values);
$max = max($values);
$displayMin = $min > 2 ? $min - 3 : $min;

$chartOptions = array(
	'values' => $values,
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