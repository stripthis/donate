<div class="content">
<?php
echo $this->element('nav', array(
	  'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
  ));
?>
<h1><?php echo $this->pageTitle = 'Details for ' . $user['User']['login']; ?></h1>

<?php
echo $form->create('User', array('url' => $this->here));
echo $form->input('id', array('type' => 'hidden', 'value' => $user['User']['id']));
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
	$checked = Common::requestAllowed($controller, $action, $user['Role']['permissions'], true);
	$checked = $checked && Common::requestAllowed($controller, $action, $user['User']['permissions'], true);
	echo $form->input('permissions.' . $perm, array(
		'label' => $label,
		'type' => 'checkbox', 'value' => '',
		'checked' => $checked ? 'checked' : ''
	));
}
echo $form->end('Save');
?>
</div>