<div class="index_wrapper">
	<?php
	$foundOne = false;
	$amount = __('Amount', true);
	$frequency = __('Frequency', true);
	$due = __('Due', true);
	$fname = __('First Name', true);
	$lname = __('Last Name', true);
	$email = __('Email', true);
	$date = __('Date', true);

	$content = <<<HTML
	<table>
		<thead>
			<tr>
				<th class="fold">&nbsp;</th>
				<th class="favorites">&nbsp;</th>
				<th class="status">&nbsp;</th>
				<th class="title">
					{$amount}
					{$frequency}
					{$due}
				</th>
				<th class="description">
					{$fname}
					{$lname}
					{$email}
				</th>
				<th></th>
				<th></th>
				<th class="date">{$date}</th>
				<th class="grab"></th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
HTML;

	foreach ($gifts as $gift) {
		if (empty($gift['Gift'])) {
			continue;
		}
		$foundOne = true;

		$options = array(
			'parent_id' => $gift['Gift']['id'],
			'gift' => $gift,
			'leaf' => 0,
			'do_selection' => 0,
			'do_fold' => 0
		);

		$colsToAppend = '<td>' . $html->link(__('Remove from Segment', true),
			array(
				'controller' => 'segments', 'action' => 'delete_item',
				$segment['Segment']['id'], $gift['Gift']['id']
			), null, 'Are you sure?'
		) . '</td>';
		$options['colsToAppend'] = $colsToAppend;
		$content .= $this->element('tableset/rows/gift', $options);
	}
	$content .= '</tbody></table>';
	if ($foundOne) {
		echo $content;
	} else {
		echo '<p class="nothing">' . __("Sorry but there is nothing to display here...", true) . '</p>';
	}
	?>
</div>