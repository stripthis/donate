<div class="content" id="statistic_index">
	<?php echo $this->element("admin/quicklinks"); ?>
	<h2><?php echo __('Statistics'); ?></h2>
	<div class="menu_wrapper">
		<ul class="menu with_tabs">
			<li><?php echo $html->link(__('Signups (partial)',true), array('action'=>'index/gifts','admin'=>true),array('class'=>'selected')); ?></li>
			<!-- <li><?php echo $html->link(__('Gifts (complete)',true), array('action'=>'index/gifts','admin'=>true)); ?></li>
			<li><?php echo $html->link(__('Amounts',true), array('action'=>'index/gifts','admin'=>true)); ?></li> -->
		</ul>
	</div>
	<?php echo $this->element('../statistics/elements/filter') ?>
	<?php
	$url = '/admin/statistics/index.json?startDate=' . $startDate . '&endDate=' . $endDate;
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
