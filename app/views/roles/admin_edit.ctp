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
?>

<h3>Permissions</h3>
<?php
$permissions = Configure::read('App.permission_options');

foreach ($permissions as $perm) {
	$perm = trim($perm);
	$permData = explode(':', $perm);
	$controller = $permData[0];
	$action = $permData[1];

	$label = $controller . ' ' . Inflector::humanize($action);
	$checked = Common::requestAllowed($controller, $action, $role['Role']['permissions'], true);
	echo $form->input('permissions.' . $perm, array(
		'label' => $label,
		'type' => 'checkbox', 'value' => '',
		'checked' => $checked ? 'checked' : ''
	));
}
echo $form->end('Save');
?>