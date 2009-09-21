<div class="content edit" id="users_edit">
	<h2><?php echo __('Public Key'); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<p>The public key is used to generate the encryption for your report emails.</p>
	<?php echo $form->create('User', array('url' => $this->here)); ?>
	<fieldset class="half">
		<?php echo $form->input('User.public_key', array('label' => 'Your Public Key:')); ?>
	</fieldset>
	<div class="clear"></div>
	<?php echo $form->end(__('Save', true)); ?>
</div>