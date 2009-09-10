<?php
$links = array(
	array(
		'name' => __('Import Transactions Results', true),
		'label' => 'add', 'uri' => array('action'=>'import', 'all', 'admin' => true),
		'options'=>array('class'=>'import')
	)
);
echo $this->element('admin/actions',array('links'=>$links, 'selected'=>false));

$export = isset($export) ? $export : false;

if ($export) {
	echo $form->submit('Export Selection');
	echo $form->submit('Export All Pages', array('name' => $type));
}
?>
