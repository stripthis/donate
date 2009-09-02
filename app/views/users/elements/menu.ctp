<?php
if(!isset($type)) $type = '';
$links[] = array('name' => __('Same office',true), 'label'=>'all', 'uri' => array('action'=>'index', 'colleagues', 'admin' => true));
$links[] = array('name' => __('All',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
echo $this->element('admin/menu1', array('selected'=>$type,'links'=>$links));
?>
