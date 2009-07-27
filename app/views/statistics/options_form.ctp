<?php
echo $form->create('Statistics', array('url' => $this->here));
echo $form->input('startDate', array(
	'label' => 'Start Date:',
	'type' => 'date',
	'selected' => $startDate,
	'dateFormat' => 'MY',
	'maxYear' => date('Y')
));
echo $form->input('endDate', array(
	'label' => 'End Date:',
	'type' => 'date',
	'selected' => $endDate,
	'dateFormat' => 'MY',
	'maxYear' => date('Y')
));

echo $form->end('Filter');
?>
<div class="clear"></div>