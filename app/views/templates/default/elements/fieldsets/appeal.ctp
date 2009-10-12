<?php if (!isset($appealOptions)) : ?>
	<?php echo $form->input('Gift.appeal_id', array('type' => 'hidden')); ?>
<?php else : ?>
	<fieldset>
		<legend><?php __('Please select an appeal'); ?></legend>
	<?php echo $form->input('Gift.appeal_id', array('options' => $appealOptions)); ?>
	</fieldset>
<?php endif; ?>