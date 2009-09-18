<?php
$links = array();
$export = isset($export) ? $export : false;
if ($export) {
	$links[] = array(
		'name' => __('Export Selection', true),
		'label'=>'export',
		'uri' => array(), 
		'submit' => true,
		'options'=> array('div'=> array('class'=>'submit export'))
	);
}
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));
?>