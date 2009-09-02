<h1>My Preferences</h1>
<div class="content edit" id="users_edit">
	<?php echo $html->link('Change My password', array('action' => 'edit_password'))?>
	<?php echo $form->create('User', array('url' => $this->here));?>
	<?php
	echo $form->input('login', array('label' => 'Login / Email'));
	echo $form->input('Contact.salutation', array('options' => Configure::read('App.contact.salutations')));
	echo $form->input('Contact.fname', array('label' => 'First Name'));
	echo $form->input('Contact.lname', array('label' => 'Last Name'));
	echo $form->end('Save');
	?>
</div>