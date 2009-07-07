<h2>Users Statistics</h2>
<?php echo $this->element('../statistics/sidebar') ?>

<?php
$url = '/statistics/users.json?startDate=' . $startDate . '&endDate=' . $endDate;
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
	<dt>Number of signups in the timeperiod</dt>
	<dd><?php echo count($users) ?></dd>
	<dt>Average number of signups per month (<?php echo count($months) ?> month(s) in the timeperiod)</dt>
	<dd><?php echo count($months) != 0 ? round(count($users) / count($months), 2) : 0?></dd>
</dl>
<table>
	<thead>
		<th>Monat</th><th>Number of signups</th>
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