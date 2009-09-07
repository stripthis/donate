<div class="content edit" id="users_edit">
	<h2><?php echo __('My Account'); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $form->create('User', array('url' => '/admin/users/edit_password', 'id' => 'UserAddForm')); ?>
	<fieldset>
		<legend>Changing your Password</legend>
		<br/>
		<em>Please provide your current password and provide your new password in the other two fields.</em>
		<div class="divider big"></div>
		<?php if ($session->read('lost_password') == false) : ?>
			<?php echo $form->input('User.current_password', array('label' => 'Current Password:', 'type' => 'password', 'style' => 'width: 350px;'));?>
		<?php endif; ?>
		<?php echo $form->input('User.password', array('label' => 'Password:', 'style' => 'width: 350px;')); ?>
		<?php echo $form->input('User.repeat_password', array('label' => 'Repeat Password:', 'type' => 'password', 'style' => 'width: 350px;')); ?>
	</fieldset>
	<?php echo $form->submit('Save Changes'); ?>
	<?php echo $form->end(); ?>
	<div class="clear"></div>
</div>