<?php
$links[] = array('name' => __('Add Gift',true), 'label'=>'add', 'uri' => array('action'=>'add', 'all', 'admin' => true), 'options'=>array('class'=>'gift_add'));
$links[] = array('name' => __('Export Selection',true), 'label'=>'add', 'uri' => array('action'=>'export', 'all', 'admin' => true), 'options'=>array('class'=>'export'));
$links[] = array('name' => __('Import Gifts Data',true), 'label'=>'add', 'uri' => array('action'=>'import', 'all', 'admin' => true), 'options'=>array('class'=>'import'));
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
