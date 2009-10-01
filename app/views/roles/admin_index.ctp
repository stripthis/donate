<?php 
	pr($roles);
?>
<div class="content users index">
	<h2><?php echo $this->pageTitle = __('Roles & Permissions', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_root_admin_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php	echo $this->element('../roles/elements/actions'); ?>
	<table>
		<thead>
		<tr>
			<th><?php __('Name'); ?></th>
			<th><?php __('Description'); ?></th>
			<th><?php __('Last Modification'); ?></th>
			<th><?php __('Actions'); ?></th>
		</tr>
		</thead>
		<tbody>
<?php foreach ($roles as $role) : ?>
			<tr>
				<td><?php echo Inflector::humanize($role['Role']['name']); ?></td>
				<td><?php echo $role['Role']['description']; ?></td>
				<td><?php echo $role['Role']['modified']; ?></td>
				<td>
				<?php
					if (in_array($role['Role']['name'], $uneditableRoles)) {
						echo __('(Uneditable)', true);
					} else {
						echo $html->link(__('Edit',true), array('action' => 'edit', $role['Role']['id']));
						echo ' - ';
						echo $html->link(__('Delete', true), array(
							'action' => 'delete', $role['Role']['id']),
							null, __('Are you sure?', true)
						);
					}
				?>
				</td>
			</tr>
<?php endforeach; ?>
		</tbody>
	</table>
</div>