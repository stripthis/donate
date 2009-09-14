<h2>Users &amp; Permissions</h2>

<?php if (empty($office['User'])) : ?>
	<p>Sorry, no users set up yet for this office. Please consult a root admin to add a new user to your office.</p>
<?php else : ?>
	<?php
	$permissions = Configure::read('App.permission_options');
	?>
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