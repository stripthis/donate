<div class="filter">
	<?php
	echo $form->create('Log', array('url' => '/admin/logs/index/', 'type' => 'get'));
	echo $this->element('admin/filters/paging_limit');
	echo $this->element('admin/filters/time_range');
	
	$models = Configure::read('Logging.models');
	$models = array_combine($models, $models);
	echo $form->input('model', array(
		'options' => $models, 'selected' => $params['model'],
		'empty' => 'All'
	));
	echo $form->input('user_id', array(
		'options' => $userOptions, 'selected' => $params['user_id'],
		'empty' => 'All'
	));
	echo $form->end('Filter');
	?>
</div>
<div class="clear"></div>