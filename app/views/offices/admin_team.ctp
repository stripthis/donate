<div class="content" id="offices_index">
	<h2><?php __('People Working in this Office');?></h2>
	<table>
	<?php
	$th = array(
		$paginator->sort('level'),
		$paginator->sort('name'),
		$paginator->sort('created')
	);
	echo $html->tableHeaders($th);
	foreach ($users as $user) {
		$tr = array(
			$user['User']['level'],
			$user['User']['name'],
			date('Y-m-d', strtotime($user['User']['created'])),
		);
		echo $html->tableCells($tr);
	}
	?>
	</table>
	<?php echo $this->element('paging', array('model' => 'User'))?>
</div>