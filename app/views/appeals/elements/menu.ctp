<?php
if(!isset($type) || empty($type)) $type = 'office';
$links[] = array('name' => __('My office',true), 'label'=>'office', 'uri' => array('action'=>'index', 'office', 'admin' => true));
$links[] = array('name' => __('All Appeals',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
echo $this->element('admin/menu1', array('selected'=>$type,'links'=>$links));
?>
