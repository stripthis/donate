<div class="content edit" id="appeal_form">
	<h1><?php echo sprintf(__('%s Appeal', true), ucfirst($action)); ?></h1>
	<?php echo $form->create('Appeal');?>
	<fieldset>
		<legend><?php __('Identifiers'); ?></legend>
		<?php echo $form->input('id'); ?>
		<?php echo $form->input('name'); ?>
		<?php echo $form->input('slug', array('label' => __('Slug (Generated based on name if left empty)', true))); ?>
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
		<legend><?php __('Template'); ?></legend>
		<?php echo $form->input('template_id', array('options' => $templateOptions)); ?>
	</fieldset>
		<fieldset>
		<legend><?php __('Processing'); ?></legend>
		<?php echo $form->input('processing', array('options' => $processingOptions)); ?>
		<?php echo $form->input('gateway_id', array('options' => $gatewayOptions));?>
	</fieldset>
		<fieldset>
		<legend><?php __('Themes'); ?></legend>
		<div class='half'>
			<?php
			$numThemes = count($themes);
			$i = 0;
			foreach ($themes as $theme) {
				$i++;
				if ($numThemes > 1 && $i <= $numThemes / 2) {
					$i = 0;
					echo '</div><div class="half">';
				}
			
				echo $form->input('Appeal.themes.' . $theme['Theme']['id'], array(
					'label' => ucfirst($theme['Theme']['name']),
					'type' => 'checkbox', 'value' => '',
					'checked' => false ? 'checked' : '',
					'options' => false
				));
			}
			?>
		</div>
	</fieldset>
	<?php
		// echo $form->input('lang', array(
		// 	'options' => Configure::read('App.languages'), 'label' => 'Supported Language'
		// ));

		if (User::allowed('Appeals', 'publish')) {
			$infStatusOptions = array_map('ucfirst', $statusOptions);
			$statusOptions = array_combine($statusOptions, $infStatusOptions);
			echo $form->input('status', array('options' => $statusOptions));
		} else {
			echo '<p>This Appeal is ' . $form->data['Appeal']['status'] . '. You do not have permission to change the status.</p>';
		}
		?>
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>