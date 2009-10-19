<?php
require_once WWW_ROOT . 'php-ofc-library/open-flash-chart.php';
$title = sprintf(__('%s Transactions in the analysis', true), $erronousCount + $notErronousCount);
$title = new title($title);
$data = array(
	new pie_value($erronousCount, 'Erronous Transactions'),
	new pie_value($notErronousCount, 'Successful Transactions')
);
$pie = new pie();

$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
$pie->add_animation(new pie_fade());
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_colours(array('#d01f3c','#356aa0'));
$pie->set_values($data);

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );


$chart->x_axis = null;

echo $chart->toPrettyString();
?>