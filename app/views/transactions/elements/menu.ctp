<?php
if(!isset($type) || empty($type)) $type = 'all';
$links[] = array('name' => __('All',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
$links[] = array('name' => __('Pending',true), 'label'=>'pending', 'uri' => array('action'=>'index', 'harderror', 'admin' => true));
$links[] = array('name' => __('Hard Errors',true), 'label'=>'harderror', 'uri' => array('action'=>'index', 'harderror', 'admin' => true));
$links[] = array('name' => __('Soft Errors',true), 'label'=>'softerror', 'uri' => array('action'=>'index', 'softerror', 'admin' => true));
$links[] = array('name' => __('Retried',true), 'label'=>'retried', 'uri' => array('action'=>'index', 'retried', 'admin' => true));
$links[] = array('name' => __('Successfull',true), 'label'=>'sucess', 'uri' => array('action'=>'index', 'success', 'admin' => true));
echo $this->element('admin/menu1', array('selected'=>$type,'links'=>$links));
?>
