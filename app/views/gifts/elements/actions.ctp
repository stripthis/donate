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
	$params = $this->params['url'];
	$url = $params['url'];
	unset($params['ext'], $params['url']);

	$links[] = array(
		'name' => __('Save Filter', true),
		'label' => 'export',
		'uri' =>array(
			'controller' => 'filters', 'action' => 'add',
			'?link=' . $url . '&' . http_build_query($params)
		), 
		'options'=> array('class' => 'export filters')
	);
}

echo $this->element('admin/actions', array('links' => $links, 'selected' => false));
?>