<div class="content" id="appeal_form">
  <h1><?php echo __(ucfirst($action) . ' Appeal', true); ?></h1>
<?php echo $form->create('Appeal');?>
	<fieldset>
  <?php
    echo $form->input('id');
    echo $form->input('name');
    echo $form->input('campaign_code');
    echo $form->input('default');
    echo $form->input('starred');
    echo $form->input('cost');
    echo $form->input('reviewed');
    echo $form->input('status');
	$max = 5;
	$steps = isset($form->data['AppealStep']) ? $form->data['AppealStep'] : array();
	for ($i = 1; $i <= $max; $i++) {
		$label = 'Label for Step ' . $i;
		if ($i > 1) {
			$label .= ' (optional)';
		}
		$value = isset($steps[$i - 1]) ? $steps[$i - 1]['name'] : '';
    	echo $form->input('Appeal.steps.' . $i, compact('label', 'value'));
	}
    echo $form->input('country_id', array('options' => $countryOptions));
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
