<?php
$title = $action == 'add'
			? __('Add a role', true)
			: sprintf(__('Manage the role %s', true), $role['Role']['name']);
?>
<h1><?php echo $this->pageTitle = $title; ?></h1>

<?php
echo $form->create('Role', array('url' => $this->here));
echo $form->input('id', array('type' => 'hidden'));
echo $form->input('name', array('label' => 'Name:'));
echo $form->input('permissions', array('label' => 'Permissions:'));
echo $form->end('Save');
?>