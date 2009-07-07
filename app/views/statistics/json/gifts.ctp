<?php
require_once WWW_ROOT . 'php-ofc-library/open-flash-chart.php';

$title = 'Gifts ' . date('F Y', $startDate) . ' - ' . date('F Y', $endDate);
$title = new title($title);
$chart = new open_flash_chart();
$chart->set_title($title);

$bar = new bar_3d();
$values = array();
foreach ($result as $date => $gifts) {
	$values[] = count($gifts);
}
$bar->set_values($values);
$bar->colour = '#336699';

$x = new x_axis();
$labels = array_keys($result);
foreach ($labels as $i => $label) {
	$labels[$i] = date('m.y', strtotime($label));
}
$x->set_labels_from_array($labels);
$chart->set_x_axis($x);

$y = new y_axis();
$min = min($values);
$max = max($values);
$displayMin = $min > 2 ? $min - 3 : $min;
$y->set_range($displayMin, $max + 3);

$steps = ceil(($max - $min) / 10);
$y->set_steps($steps);
$chart->set_y_axis($y);

$chart->add_element($bar);

echo $chart->toString();
?>