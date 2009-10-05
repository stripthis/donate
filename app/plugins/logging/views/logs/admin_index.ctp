<div class="content" id="logs_index">
	<h1><?php echo $this->pageTitle = 'Logs'; ?></h1>

	<?php if (empty($logs)) : ?>
		<p>Nothing to show here</p>
	<?php else : ?>
		<?php
		$options = array(
			'ids' => array(
				'Gift' => 'serial',
				'Transaction' => 'serial'
			),
			'showIds' => true,
			'showData' => true
		);
		$logs = $myLog->events($logs, $options);

		$urlParams = $params;
		$urlParams['merge'] = true;

		unset($urlParams['ext']);
		unset($urlParams['page']);
		?>

		<table>
			<tr>
				<th><?php echo $paginator->sort('#', 'continous_id')?></th>
				<th>Event</th>
				<th>Changed Data</th>
				<th>Date</th>
			</tr>
			<?php foreach ($logs as $log) : ?>
				<tr>
					<td><?php echo $log['Log']['continous_id']?></td>
					<td><?php echo $log['Log']['event']?></td>
					<td>
						<ul>
							<?php foreach ($log['Log']['change'] as $change) : ?>
								<li><?php echo trim($change)?></li>
							<?php endforeach; ?>
						</ul>
					</td>
					<td><?php echo $log['Log']['created']?>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->element('paging', array('model' => 'Log', 'url' => $urlParams)); ?>
	<?php endif; ?>
	<?php echo $this->element('filter', array('params' => $params, 'plugin' => 'logging')); ?>
</div>