<?php
$this->pageTitle = __('Preferences', true);
?>
<div class="content edit" id="users_edit">
	<h2><?php echo __('My Account', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $form->create('User', array('url' => $this->here));?>
	<fieldset>
	<legend><?php echo __('Help & Language', true); ?></legend>
	<?php
	echo $form->input('login', array('label' => 'Login / Email'));
	echo $form->input('User.lang', array('label' => 'Language', 'options' => $langOptions));
	echo $form->input('User.tooltips', array('label' => 'Show Tooltips?'));
	?>
	</fieldset>
	<fieldset>
	  <legend><?php echo __('Contact Details', true); ?></legend>
	  <?php echo $form->input('Contact.salutation', array('options' => Configure::read('App.contact.salutations'))); ?>
	  <?php echo $form->input('Contact.fname', array('label' => 'First Name')); ?>
	  <?php echo $form->input('Contact.lname', array('label' => 'Last Name')); ?>
	</fieldset>
	<?php echo $form->end('Save'); ?>
</div>