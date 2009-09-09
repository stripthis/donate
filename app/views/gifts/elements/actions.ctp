<?php
$links = array(
	array(
		'name' => __('Add Gift', true),
		'label'=>'add', 'uri' => array(
			'action' => 'add', 'all', 'admin' => true
		),
		'options'=>array('class' => 'gift_add')
	),
	array(
		'name' => __('Import Gifts Data', true),
		'label'=>'add',
		'uri' => array(
			'action' => 'import', 'all', 'admin' => true
		),
		'options'=>array('class' =>' import')
	)
);
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));

$export = isset($export) ? $export : false;

if ($export) {
	echo $form->submit('Export Selection');
}
?>