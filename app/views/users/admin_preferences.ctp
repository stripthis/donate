<div class="content edit" id="users_edit">
	<h2><?php echo __('My Account'); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $form->create('User', array('url' => $this->here));?>
	<?php
	echo $form->input('login', array('label' => 'Login / Email'));
	echo $form->input('Contact.salutation', array('options' => Configure::read('App.contact.salutations')));
	echo $form->input('Contact.fname', array('label' => 'First Name'));
	echo $form->input('Contact.lname', array('label' => 'Last Name'));
	echo $form->input('User.tooltips', array('label' => 'Show Toolstips?'));
	$langOptions = array(
		'eng' => 'English',
		'fre' => 'French'
	);
	echo $form->input('User.lang', array('label' => 'Language', 'options' => $langOptions));
	echo $form->end('Save');
	?>
</div>