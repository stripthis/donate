<div class="content" id="offices_index">
	<h2><?php sprintf(__('People Working in this Office', true));?></h2>
	<table>
	<?php
	$th = array(
		$paginator->sort('level'),
		$paginator->sort('name'),
		$paginator->sort('created')
	);
	echo $html->tableHeaders($th);
	foreach ($users as $user) {
		$date = date('Y-m-d', strtotime($user['User']['created']));
		$creator = $user['CreatedBy']['login'];
		$created = sprintf('%s by %s', $date, $creator);
		$tr = array(
			$user['User']['level'],
			$user['User']['name'],
			$created,
		);
		echo $html->tableCells($tr);
	}
	?>
	</table>
	<?php echo $this->element('paging', array('model' => 'User'))?>
</div>