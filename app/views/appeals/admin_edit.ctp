<?php
	$numThemes = count($themes);
	$i = 0;
?>
<div class="content edit" id="appeal_form">
	<h1><?php echo sprintf(__('%s Appeal', true), ucfirst($action)); ?></h1>
	<?php echo $form->create('Appeal');?>
	<fieldset>
		<legend><?php __('Idenfiers'); ?></legend>
		<?php echo $form->input('id'); ?>
		<?php echo $form->input('name'); ?>
		<?php echo $form->input('slug'); ?>
	</fieldset>	
	<fieldset>
		<legend><?php __('Status'); ?></legend>
		<?php echo $form->input('default'); ?>
		<?php echo $form->input('reviewed');?>
	</fieldset>
	<fieldset>
		<legend><?php __('Objectives'); ?></legend>
		<?php echo $form->input('campaign_code'); ?>
		<?php echo $form->input('cost');?>
		<?php echo $form->input('targeted_income');?>
		<?php echo $form->input('targeted_signups');?>
	</fieldset>
		<fieldset>
		<legend><?php __('Themes'); ?></legend>
		<div class='half'>
<?php	foreach ($themes as $theme): $i++; ?>
<?php 	if ($numThemes > 1 && $i <= $numThemes / 2) : $i = 0; ?>
				</div>
				<div class="half">
<?php 	endif; ?>
					<?php 
					echo $form->input('themes.' . $theme['Themes']['id'], array(
						'label' => ucfirst($theme['Themes']['name']),
						'type' => 'checkbox', 'value' => '',
						'checked' => false ? 'checked' : ''
					))."\n";
					?>
<?php endforeach; ?>
	</div>
	</fieldset>
	<?php
		//@todo TO BE MOVED TO APPEALS TEMPLATES VIEW
		/*
		echo $form->input('lang', array(
			'options' => Configure::read('App.languages'), 'label' => 'Supported Language'
		));

		$infStatusOptions = array_map('ucfirst', $statusOptions);
		$statusOptions = array_combine($statusOptions, $infStatusOptions);
		echo $form->input('status', array('options' => $statusOptions));
		$max = 5;
		$steps = isset($form->data['AppealStep']) ? $form->data['AppealStep'] : array();
		for ($i = 1; $i <= $max; $i++) {
			$label = 'Label for Step ' . $i;
			if ($i > 1) {
				$label .= ' (optional)';
			}
			$value = isset($steps[$i - 1]) ? $steps[$i - 1]['name'] : '';
			echo $form->input('Appeal.steps.' . $i, compact('label', 'value'));
		}*/
		?>
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>