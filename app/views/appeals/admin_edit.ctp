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
		<legend><?php __('Processing'); ?></legend>&nbsp;
		<?php echo $form->input('gateway_id', array('options' => $gatewayOptions));?>
	</fieldset>
		<fieldset>
		<legend><?php __('Themes'); ?></legend>
		<div class='half'>
			<?php
			$numThemes = count($themes);
			$i = 0;
			$selected = array();
			if (isset($appeal)) {
				$selected = Set::extract('/Theme/id', $appeal);
			}
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
					'options' => false,
					'checked' => in_array($theme['Theme']['id'], $selected)
				));
			}
			?>
		</div>
	</fieldset>
		<?php
		if (User::allowed('Appeals', 'publish')) {
			echo $form->input('published');
		} else {
			$msg = __('This Appeal is "published".', true);
			if (!$form->data['Appeal']['published']) {
				$msg = __('This Appeal is "not published".', true);
			}
			$msg .= ' ' . __('You do not have permission to change the status.', true);
			echo '<p>' . $msg . '</p>';
		}
		?>
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>