<div class="content add" id="template_form">
	<h2><?php echo __('Edit Template', true); ?></h2>
	<?php	echo $this->element('../templates/elements/actions'); ?>
	<?php echo $form->create('Template');?>
	<?php echo $form->input('id', array('type' => 'hidden'))?>
	<fieldset>
		<legend><?php __('Details'); ?></legend>
		<label><?php echo __('Name', true)?></label>
		<?php echo $template['Template']['name']; ?>
		<label><?php echo __('Url Slug', true)?></label>
		<?php echo $template['Template']['slug']; ?>
	</fieldset>
	<fieldset class="steps">
		<legend><?php __('Steps'); ?></legend>
		<p><?php echo __('The Thank you step was automatically created for you.', true) ?></p>
		<p><?php echo __('In order to remove a step, just empty its textbox.', true) ?></p>
		<?php
		$count = $template['Template']['template_step_count'];

		// thanks page is a separate step
		if ($count > 1) {
			for ($i = 1; $i < $count; $i++) {
				$value = '';
				$path = VIEWS . 'templates' . DS . $template['Template']['slug'] . '_' . $template['Template']['id'];
				$file = $path . DS . 'step' . $i . '.ctp';

				if (file_exists($file)) {
					$value = file_get_contents($file);
				}
				echo $form->input('step.' . $i, array(
					'type' => 'textbox',
					'value' => $value,
					'label' => sprintf(__('Step %s:', true), $i),
					'rel' => $i
				));
			}
		}
		?>
		<?php echo $html->link(__('Add Step', true), '#', array('class' => 'add-step'))?>
	</fieldset>
	<fieldset class="thanks-step">
		<legend><?php __('Last Step'); ?></legend>
		<?php
		$path = VIEWS . 'templates' . DS . $template['Template']['slug'] . '_' . $template['Template']['id'];
		$file = $path . DS . 'thanks.ctp';
		$value = file_get_contents($file);
		echo $form->input('step.thanks', array(
			'type' => 'textbox',
			'value' => $value,
			'label' => __('Thank you Step:', true),
			'rel' => 'thanks'
		));
		?>
	</fieldset>
	<?php echo $form->end('Save');?>
</div>