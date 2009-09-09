<?php
$links[] = array('name' => __('Export Selected Transactions',true), 'label'=>'add', 'uri' => array('action'=>'export', 'all', 'admin' => true), 'options'=>array('class'=>'export'));
$links[] = array('name' => __('Import Transactions Results',true), 'label'=>'add', 'uri' => array('action'=>'import', 'all', 'admin' => true), 'options'=>array('class'=>'import'));
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>
