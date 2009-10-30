<div class="filter">
	<?php
	echo $form->create('Statistics', array('url' => $this->here));
	echo $form->input('startDate', array(
		'label' => 'Start Date:',
		'type' => 'datetime',
		'timeFormat' => '24',
		'selected' => $startDate,
		'maxYear' => date('Y')
	));
	echo $form->input('endDate', array(
		'label' => 'End Date:',
		'type' => 'datetime',
		'timeFormat' => '24',
		'selected' => $endDate,
		'maxYear' => date('Y')
	));
	?>
	<div class="clear"></div>
	<?php echo $form->end('Filter'); ?>
</div>
<div class="clear"></div>