<div class="content">
<h1>Bugs</h1>
<?php echo $html->link('Resent All Bugs As Email', array('action' => 'resent_all')); ?>
<table>
<?php
$th = array(
	__('Id', true),
	__('Created', true),
	__('User', true),
	__('Last thing that was done', true),
	__('Description', true),
	__('actions', true)
);
echo $html->tableHeaders($th);
foreach ($bugs as $bug) {
	$actions = array(
		$html->link('Delete', array(
			'plugin' => 'bugs',
			'action' => 'delete', $bug['Bug']['id']
		), null, 'Are you sure?')
	);
	$tr = array(
		'#' . $bug['Bug']['increment'],
		method_exists($common, 'date') 
			? $common->date($bug['Bug']['created'])
			: $bug['Bug']['created'],
		$bug['User']['login'],
		$bug['Bug']['last_thing'],
		$bug['Bug']['bug_descr'],
		implode(' - ', $actions)
	);
	echo $html->tableCells($tr);
}
?>
</table>
</div>