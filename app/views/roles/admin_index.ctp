<div class="content users index">
	<h2><?php echo $this->pageTitle = __('Roles & Permissions', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_root_admin_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>

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
</div>