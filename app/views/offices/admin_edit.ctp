<div class="content" id="offices_form">
  <h2><?php __('Edit Office');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Office.id')), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Office.id'))); ?></li>
      <li><?php echo $html->link(__('New Office', true), array('action'=>'add'), array('class' => 'add')); ?></li>
		<?php if (USer::isRoot()) : ?>
			<li><?php echo $html->link(__('Manage Tree', true), array('action' => 'manage_tree'), array('class' => 'tree')); ?></li>
		<?php endif; ?>
</ul>
  </div>
<?php echo $form->create('Office');?>
<?php
echo $form->input('id');
echo $form->input('name');
echo $form->input('frequencies', array(
	'label' => '', 'options' => Gift::find('frequencies', array('options' => true)), 'multiple' => true,
	'selected' => explode(',', $form->data['Office']['frequencies'])
));

echo $form->input('amounts', array(
	'value' => $form->data['Office']['amounts'], 'label' => 'Possible Amount Selections:'
));

echo $form->input('gateways', array(
	'options' => $gatewayOptions,
	'selected' => $selectedGateways, 'multiple' => true,
	'label' => 'Supported Gateways (leave empty if none):',
	'empty' => '-- None --'
));
?>

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
<?php echo $form->end('Save');?>
</div>