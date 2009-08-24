  <div class="offices index">
  <h2><?php __('Offices');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('New Office', true), array('action' => 'add'), array('class' => 'add')); ?></li>
    </ul>
  </div>
<table>
<?php
$th = array(
	$paginator->sort('name'),
	$paginator->sort('parent_id'),
	$paginator->sort('created'),
	$paginator->sort('modified'),
	'Actions'
);
echo $html->tableHeaders($th);
foreach ($offices as $office) {
	$actions = array(
		$html->link(__('View', true), array('action' => 'view', $office['Office']['id']), array('class'=>'view')),
		$html->link(__('Edit', true), array('action' => 'edit', $office['Office']['id']), array('class'=>'edit')),
		$html->link(__('Delete', true), array('action' => 'delete', $office['Office']['id']),
			array('class' => 'delete'), __('Are you sure?', true))
	);

	$tr = array(
		$office['Office']['name'],
		$office['ParentOffice']['name'],
		$office['Office']['created'],
		$office['Office']['modified'],
		implode(' - ', $actions)
	);
	echo $html->tableCells($tr);
}
?>
</table>
<?php echo $this->element('paging', array('model' => 'Office'))?>
</div>