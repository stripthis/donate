<h2><?php echo __('Users Statistics', true); ?></h2>
<?php echo $this->element('../statistics/sidebar') ?>

<?php
$url = '/admin/statistics/users.json?startDate=' . $startDate . '&endDate=' . $endDate;
?>
<script type="text/javascript">
swfobject.embedSWF(
  "/open-flash-chart.swf", "my_chart", "550", "300",
  "9.0.0", "expressInstall.swf",
  {"data-file":"<?php echo urlencode($url) ?>"}
);
</script>
<div id="my_chart"></div>
<div class="divider"></div>

<dl class="stats">
	<dt><?php echo __('Number of signups in the timeperiod', true); ?></dt>
	<dd><?php echo count($users) ?></dd>
	<dt><?php echo sprintf(__('Average number of signups per month (%s month(s) in the timeperiod)', true), count($months)); ?></dt>
	<dd><?php echo count($months) != 0 ? round(count($users) / count($months), 2) : 0?></dd>
</dl>
<table>
	<thead>
		<th><?php echo __('Monat', true); ?></th><th><?php echo __('Number of signups', true); ?></th>
	</thead>
	<tbody>
		<?php foreach ($result as $month => $users) : ?>
			<tr>
				<td><?php echo date('F Y', strtotime($month))?></td>
				<td><?php echo count($users)?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>