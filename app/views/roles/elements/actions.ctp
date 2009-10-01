<?php
$links[] = array(
	'name' => __('Add a role',true),
	'label'=>'add',
	'uri' => array('action'=>'add', 'admin' => true),
	'options'=>array('class'=>'add')
);
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
