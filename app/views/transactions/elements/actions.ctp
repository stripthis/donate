<?php
if(!isset($links)){
	$links = array();
}
switch($this->action){
	case "admin_index":
		/*
		$links[] =	array(
			'name' => __('Import Transactions Results', true),
			'label' => 'add', 'uri' => array('action'=>'import', 'all', 'admin' => true),
			'options'=>array('class'=>'import')
		);*/
		$links[] = array(
			'name' => __('Export Selection', true),
			'label'=>'export',
			'uri' => array(), 
			'submit' => true,
			'options'=> array('div'=> array('class'=>'submit export'))
		);
		$links[] = array(
			'name' => __('Export All', true),
			'label'=>'exportall',
			'uri' => array(), 
			'submit' => true,
			'options'=> array('class' =>'exportall', 'name' => 'Transaction', 'div'=> array('class'=>'submit exportall'))
		);
	break;
	case "admin_view":
		$links[] = array(
			'name' => __('back to index', true),
			'label'=>'back to index',
			'uri' => array('action'=>'index','all'), 
			'options'=> array('class' =>'back')
		);
	break;
}
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
