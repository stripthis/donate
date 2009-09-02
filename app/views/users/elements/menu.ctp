<?php
if(!isset($type)) $type = '';
switch($this->action){
	case 'admin_preferences':
	case 'edit_password':
    //$links[] = array('name' => __('Edit Contact',true), 'label'=>'preferences', 'uri' => array('action'=>'preferences', 'admin' => true));
    $links[] = array('name' => __('Edit Preferences',true), 'label'=>'preferences', 'uri' => array('action'=>'preferences', 'admin' => true));
    $links[] = array('name' => __('Edit Password',true), 'label'=>'password', 'uri' => array('action'=>'edit_password','admin' => true));
  break;
	case 'admin_index':
	  $links[] = array('name' => __('My Colleagues',true), 'label'=>'office', 'uri' => array('action'=>'index', 'office', 'admin' => true));
    $links[] = array('name' => __('All Colleagues',true), 'label'=>'all', 'uri' => array('action'=>'index', 'all', 'admin' => true));
  break;
}
echo $this->element('admin/menu1', array('selected'=>$type,'links'=>$links));
?>
