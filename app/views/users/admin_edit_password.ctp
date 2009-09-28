<div class="content edit" id="users_edit">
	<h2><?php echo __('My Account', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $form->create('User', array('url' => '/admin/users/edit_password', 'id' => 'UserAddForm')); ?>
	<fieldset class="half">
		<legend><?php echo __('Changing your Password', true); ?></legend>
		<br/>
		<p class="help"><?php echo __('Please provide your current and your new password.', true); ?></p>
		<div class="divider big"></div>
		<?php if ($session->read('lost_password') == false) : ?>
			<?php echo $form->input('User.current_password', array('label' => 'Current Password:', 'type' => 'password'));?>
		<?php endif; ?>
		<?php echo $form->input('User.password', array('label' => 'Password:')); ?>
		<?php echo $form->input('User.repeat_password', array('label' => 'Repeat Password:', 'type' => 'password')); ?>
	</fieldset>
	<div class="clear"></div>
	<?php echo $form->submit('Save Changes'); ?>
	<?php echo $form->end(); ?>
</div>