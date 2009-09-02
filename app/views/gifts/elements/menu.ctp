<?php
if(!isset($type) || empty($type)) $type = 'all';
$links[] = array('name' => __('All',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
$links[] = array('name' => __('Recurring',true), 'label'=>'recurring', 'uri' => array('action'=>'index', 'recurring', 'admin' => true));
$links[] = array('name' => __('Starred',true), 'label'=>'starred', 'uri' => array('action'=>'index', 'starred', 'admin' => true));
echo $this->element('admin/menu1',array('selected'=>$type,'links'=>$links));
?>
