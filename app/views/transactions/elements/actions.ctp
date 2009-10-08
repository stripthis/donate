<?php
if (!isset($links)){
	$links = array();
}
switch ($this->action){
	case 'admin_import':
	case 'admin_index':
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
		if (pluginLoaded('Segments')) {
			$links[] = array(
				'name' => __('Save as Segment', true),
				'label' => 'export',
				'uri' => array(), 
				'submit' => true,
				'options'=> array('div' => array('class' => 'submit export segments'))
			);
		}
		$links[] = array(
			'name' => __('Export All', true),
			'label'=>'exportall',
			'uri' => array(), 
			'submit' => true,
			'options'=> array('class' =>'exportall', 'name' => 'Transaction', 'div'=> array('class'=>'submit exportall'))
		);
		$links[] = array(
			'name' => __('Import', true),
			'label'=>'import',
			'uri' => array('action' => 'import'),
			'options'=> array('class' =>'import')
		);
	break;
	case "admin_view":
		$links[] = array(
			'name' => __('Back to index', true),
			'label'=>'back to index',
			'uri' => array('action'=>'index','all'), 
			'options'=> array('class' =>'back')
		);
	break;
}
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
