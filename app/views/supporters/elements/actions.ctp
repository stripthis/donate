<?php
$links = array(
	/*array(
		'name' => __('Add Gift', true),
		'label'=>'add', 'uri' => array(
			'action' => 'add', 'all', 'admin' => true
		),
		'options'=>array('class' => 'gift_add')
	),*/
	/* @TODO Import
	array(
		'name' => __('Import Gifts Data', true),
		'label'=>'add',
		'uri' => array(
			'action' => 'import', 'all', 'admin' => true
		),
		'options'=> array('class' =>' import')
	)*/
);
$export = isset($export) ? $export : false;
if ($export) {
	//echo $form->submit('Export Selection');
	//echo $form->submit('Export All Pages', array('name' => $type));
	/*
	$links[] = array(
		'name' => __('Export Selection', true),
		'label'=>'export',
		'uri' => array(), 
		'submit' => true,
		'options'=> array('div'=> array('class'=>'submit export'))
	);*/
	/*
	$links[] = array(
		'name' => __('Export All', true),
		'label'=>'exportall',
		'uri' => array(), 
		'submit' => true,
		'options'=> array('class' =>'exportall', 'name' => $type, 'div'=> array('class'=>'submit exportall'))
	);*/
}
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>