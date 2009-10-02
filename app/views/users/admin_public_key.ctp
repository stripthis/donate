<div class="content edit" id="users_edit">
	<h2><?php echo __('Public Key', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<p class="message information"><?php echo __('The public key is used to generate the encryption for your report emails.', true); ?></p>
	<?php echo $form->create('User', array('url' => $this->here)); ?>
	<fieldset>
		<legend><?php echo __('Your Public Key',true); ?></legend>
		<?php echo $form->input('User.public_key', array('label' => __('Please paste your public key',true).':')); ?>
	</fieldset>
	<div class="clear"></div>
	<?php echo $form->end(__('Save', true)); ?>
</div>