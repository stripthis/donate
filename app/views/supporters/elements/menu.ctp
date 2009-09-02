<?php
if(!isset($type) || empty($type)) $type = 'all';
$links[] = array('name' => __('All',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
echo $this->element('admin/menu1', array('selected'=>$type,'links'=>$links));
?>
