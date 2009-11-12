<div class="content edit" id="users_edit_password">
	<h2><?php echo __('My Account', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));

	echo $form->create('User', array('url' => '/admin/users/edit_password', 'id' => 'UserAddForm'));
	if ($session->read('lost_password') == false) {
		echo $common->help( __('Please provide your current and your new password.', true));
	}
	?>
	<fieldset class="half">
		<legend><?php echo __('Changing your Password', true); ?></legend>
		<div class="divider big"></div>
		<?php
		if ($session->read('lost_password') == false) {
			echo $form->input('User.current_password', array(
				'label' => 'Current Password:',
				'type' => 'password'
			));
		}
		echo $form->input('User.password', array(
			'label' => 'New Password:'
		));
		echo $form->input('User.repeat_password', array(
			'label' => 'Repeat Password:',
			'type' => 'password'
		));
		?>
	</fieldset>
	<div class="clear"></div>
	<?php
	echo $form->submit('Save Changes');
	echo $form->end();
	?>
</div>