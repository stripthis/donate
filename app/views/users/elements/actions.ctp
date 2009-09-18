<?php
$links[] = array(
	'name' => __('Add User',true),
	'label'=>'add',
	'uri' => array('action'=>'add', 'all', 'admin' => true),
	'options'=>array('class'=>'user_add')
);
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
