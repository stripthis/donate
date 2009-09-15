<h1><?php echo $this->pageTitle = 'Roles Management'; ?></h1>

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