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

if (pluginLoaded('Segments')) {
	$links[] = array(
		'name' => __('Save as Segment', true),
		'label' => 'export',
		'uri' => array(), 
		'submit' => true,
		'options'=> array('div' => array('class' => 'submit export segments'))
	);
}

if (pluginLoaded('Filters')) {
	$links[] = array(
		'name' => __('Save Filter', true),
		'label' => 'export',
		'uri' =>array(
			'controller' => 'filters', 'action' => 'add',
			'?link=' . $common->urlQuery($this->params)
		), 
		'options'=> array('class' => 'export filters')
	);
}

$links[] = array(
	'name' => __('Statistics', true),
	'label' => 'export',
	'uri' =>array(
		'controller' => 'transactions', 'action' => 'stats',
		'?link=' . $common->urlQuery($this->params)
	), 
	'options'=> array('class' => 'export filters')
);

echo $this->element('admin/actions', array('links' => $links, 'selected' => false));
?>