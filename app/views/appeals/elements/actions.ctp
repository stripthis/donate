<?php
if (!isset($links)){
	$links = array();
}
switch ($this->action){
	case 'admin_import':
	case 'admin_index':
		$links[] = array(
			'name' => __('Add an appeal', true),
			'label'=> 'Add',
			'uri' => array('action'=>'add'), 
			'options'=> array('class'=>'add')
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
