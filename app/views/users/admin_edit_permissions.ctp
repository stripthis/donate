<div class="content edit" id="users_edit_permissions"> 
<h2><?php echo __('Users &amp; Permissions', true); ?></h2>
<?php if (empty($office['User'])) : ?>
	<p><?php echo __('Sorry, no users set up yet for this office. Please consult a root admin to add a new user to your office.', true); ?></p>
<?php else : ?>
<?php $permissions = Configure::read('App.permissions.options'); ?>
	<ul>
	<?php foreach ($office['User'] as $user) : ?>
		<?php
		$options = array();
		$selected = array();
		foreach ($permissions as $perm) {
			$data = explode(':', $perm);
			if (Common::requestAllowed($data[0], $data[1], $user['permissions'], true)) {
				$selected[] = $perm;
			}

			$label = ucfirst(r('admin_', '', $data[1])) . ' ' . $data[0];
			$options[$perm] = $label;
		}
		?>
		<li>
			<?php echo $user['name']?>
			<?php
			echo $form->input('Office.permissions.' . $user['id'], array(
				'label' => false, 'options' => $options, 'selected' => $selected,
				'multiple' => 'checkbox'
			));
			?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>