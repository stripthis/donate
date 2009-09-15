<h1><?php echo $this->pageTitle = __('Roles & Permissions', true); ?></h1>

<?php echo $html->link('Add a Role', array('action' => 'add'))?>
<ul>
	<?php foreach ($roles as $role) : ?>
		<li>
			<?php
			if (in_array($role['Role']['name'], $uneditableRoles)) {
				echo Inflector::humanize($role['Role']['name']) . ' ';
				echo __('(Uneditable)');
			} else {
				echo $html->link(Inflector::humanize($role['Role']['name']), array('action' => 'edit', $role['Role']['id']));
				echo ' ';
				echo $html->link(__('Delete Role', true), array(
					'action' => 'delete', $role['Role']['id']),
					null, __('Are you sure?', true)
				);
			}
			?>
		</li>
	<?php endforeach ?>
</ul>

<h2>Permissions</h2>
<?php
echo $form->create('User', array('url' => $this->here));
$rolesOptions = Set::combine($roles, '/Role/id', '/Role/name');
?>
<table>
<?php
$th = array('Name', 'Office', 'Role');
echo $html->tableHeaders($th);
foreach ($users as $user) {
	$dropdown = $form->input($user['User']['id'], array(
		'options' => $rolesOptions, 'selected' => $user['Role']['id'],
		'label' => false
	));
	$tr = array(
		$user['User']['name'],
		$user['Office']['name'],
		$dropdown
	);
	echo $html->tableCells($tr);
}
?>
</table>
<?php echo $form->end('Save'); ?>