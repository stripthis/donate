<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Gift');
$favConfig = Configure::read('Favorites');
?>
<div class="content" id="gifts_index">
  <h2><?php __('Gifts');?></h2>
	<?php
	echo $form->create('Gift', array('url' => '/admin/gifts/index', 'type' => 'get'));
	echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $keyword));
	$typeOptions = array(
		'gift' => 'Gift Id',
		'person' => 'Person Name',
		'appeal' => 'Appeal Name',
		'office' => 'Office Name'
	);
	echo $form->input('type', array('label' => 'Type:', 'selected' => $type, 'options' => $typeOptions));
	echo $form->end('Filter');
	?>

<table>
<?php
$th = array(
	$paginator->sort('office_id'),
	$paginator->sort('type'),
	$paginator->sort('amount'),
	$paginator->sort('frequency'),
	$paginator->sort('appeal_id'),
	$paginator->sort('fname'),
	$paginator->sort('lname'),
	$paginator->sort('email'),
	$paginator->sort('created'),
	'Actions'
);
echo $html->tableHeaders($th);
foreach ($gifts as $gift) {
	$actions = array(
		$html->link(__('View', true), array('action'=>'view', $gift['Gift']['id']),array('class'=>'view')),
		$html->link(__('Delete', true), array(
			'action' => 'delete', $gift['Gift']['id']), array('class' => 'delete'), 'Are you sure?')
	);
	if ($doFavorites) {
		$actions[] = $html->link(__(ucfirst($favConfig['verb']), true), array(
			'controller' => 'favorites', 'action' => 'add', $gift['Gift']['id'], 'Gift'
		));
	}
	$office = $html->link($gift['Office']['name'], array(
		'controller' => 'offices', 'action' => 'view', $gift['Office']['id']
	));
	$appeal = $html->link($gift['Appeal']['name'], array(
		'controller' => 'appeals', 'action'=>'view', $gift['Appeal']['id']
	));
	$tr = array(
		$office,
		$gift['Gift']['type'],
		$gift['Gift']['frequency'],
		$gift['Gift']['amount'],
		$appeal,
		$gift['Contact']['fname'],
		$gift['Contact']['lname'],
		$gift['Contact']['email'],
		$gift['Gift']['created'],
		implode(' - ', $actions)
	);
	echo $html->tableCells($tr);
}
?>
</table>
<?php echo $this->element('paging', array('model' => 'Gift'))?>
</div>