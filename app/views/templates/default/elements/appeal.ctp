<?php if (!isset($appealOptions)) : ?>
				<?php	echo $form->input('Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>
<?php else : ?>
				<fieldset>
					<legend><?php __('Please select an appeal'); ?></legend>
				<?php echo $form->input('Gift.appeal_id', array('options' => $appealOptions))."\n"; ?>
				</fieldset>
<?php endif; ?>
