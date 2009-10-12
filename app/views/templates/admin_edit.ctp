<div class="content add" id="template_form">
	<h1><?php echo __('Edit Template', true); ?></h1>
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
		<p><?php echo __('In order to remove a step, just empty its textbox.', true) ?></p>
		<?php
		$count = $template['Template']['template_step_count'];

		for ($i = 1; $i < $count + 1; $i++) {
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
		?>
	</fieldset>
	<?php echo $html->link(__('Add Step', true), '#', array('class' => 'add-step'))?>
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
			$steps = isset($form->data['TemplateStep']) ? $form->data['TemplateStep'] : array();
			for ($i = 1; $i <= $max; $i++) {
				$label = 'Label for Step ' . $i;
				if ($i > 1) {
					$label .= ' (optional)';
				}
				$value = isset($steps[$i - 1]) ? $steps[$i - 1]['name'] : '';
				echo $form->input('Template.steps.' . $i, compact('label', 'value'));
			}*/
			?>
	<?php echo $form->end('Save');?>
</div>