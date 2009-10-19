<div class="content" id="transactions_index">
<h2>
	<?php
	$headline = __('Transactions Statistics', true);
	if (!empty($contact)) {
		$name = $common->contactName($contact);
		$headline = sprintf(__('%s\'s Transactions', true), $name);
	}
	echo $headline;
	?>
</h2>
<?php
echo $this->element('nav', array(
	'type' => 'transaction_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
));
?>
<?php
$url = '/admin/transactions/stats_erronous.json';
?>
<script type="text/javascript">
swfobject.embedSWF(
	"/open-flash-chart.swf", "my_chart", "850", "300",
	"9.0.0", "expressInstall.swf",
	{"data-file":"<?php echo urlencode($url) ?>"}
);
</script>
<div id="my_chart"></div>
<?php echo $this->element('../transactions/elements/filter', compact('params', 'type')); ?>
</div>