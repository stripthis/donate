<?php
$links = array(
	/*
	array(
		'name' => __('Add office', true),
		'label'=>'add', 'uri' => array(
			'action' => 'add', 'all', 'admin' => true
		),
		'options'=>array('class' => 'office_add')
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
switch($this->action) {
	case "admin_edit":
		$links[] = array(
		  'name'  => __('Cancel', true),
		  'label' => 'view', 
		  'uri'   => array(
		  	'action' => 'view/'.$session->read('Office.id'), 'admin' => true
		  ),
		  'options'=>array('class' => 'back')
	  );
	break;
	case "admin_index":
	break;
	case "admin_view":
		$links[] = array(
		  'name'  => __('Edit', true),
		  'label' => 'edit', 
		  'uri'   => array(
		  	'action' => 'edit/'.$session->read('Office.id'), 'admin' => true
		  ),
		  'options'=>array('class' => 'edit')
	  );
	break;
}
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