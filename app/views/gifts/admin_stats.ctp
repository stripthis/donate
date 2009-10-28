<div class="content" id="gifts_index">
	<h2><?php echo __('Statsitics', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'gift_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>

	<h3>Filter</h3>
	<?php echo $this->element('../statistics/elements/filter'); ?>
	<div class="divider big"></div>

	<h3>Gift Creation</h3>
	<?php
	$url = '/admin/gifts/stats.json?startDate=' . $startDate . '&endDate=' . $endDate;
	?>
	<script type="text/javascript">
	swfobject.embedSWF(
		"/open-flash-chart.swf", "my_chart", "850", "300",
		"9.0.0", "expressInstall.swf",
		{"data-file":"<?php echo urlencode($url) ?>"}
	);
	</script>
	<div id="my_chart"></div>
	<div class="divider"></div>
</div>
