<div class="content edit" id="users_edit">
	<?php echo $form->create('User');?>
	<?php
	echo $form->input('id');
	echo $form->input('name');
	echo $form->input('login');
	$options = array('superadmin' => 'Super Admin', 'admin' => 'Admin');
	echo $form->input('level', array('options' => $options));
	echo $form->input('Contact.salutation', array('options' => Configure::read('App.contact.salutations')));
	echo $form->input('Contact.fname', array('label' => 'First Name'));
	echo $form->input('Contact.lname', array('label' => 'Last Name'));
	echo $form->end('Save');
	?>
</div>