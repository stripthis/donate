<div class="content add" id="template_form">
	<h2><?php echo __('New Template', true); ?></h2>
	<?php	echo $this->element('../templates/elements/actions'); ?>
	<p class="message information"><?php __('Please choose an existing template to copy or create your own. Once you saved, you can edit the html/php code. Once you are fully done, make sure to add the template to a templating schedule or to an appeal directly as the current template.') ?></p>
	<?php echo $form->create('Template');?>
	<fieldset>
		<legend><?php __('Identifiers'); ?></legend>
		<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('slug', array('label' => __('Slug (Generated based on name if left empty)', true)));
		echo $form->input('template_id', array(
			'label' => __('Template to copy:', true),
			'empty' => __('Create new Template', true),
			'options' => $templateOptions
		));
		?>
	</fieldset>
	<?php echo $form->end('Save');?>
</div>