<?php
$title = $action == 'add' 
		? __('Add a role', true) 
		: __('Manage roles', true).': '. $role['Role']['name'];
$permissions = $common->getPermissions($role);
$i = $j = 0;
?>
<div class="content">
	<h1><?php echo $this->pageTitle = $title; ?></h1>
	<?php echo $form->create('Role', array('url' => $this->here)); ?>
	<?php echo $form->input('id', array('type' => 'hidden')); ?>
	<fieldset>
		<legend><?php echo __('Role Name',true); ?>: </legend>
		<?php echo $form->input('name', array('label' => __('Name',true).':')); ?>
		<?php echo $form->input('description', array('label' => __('Description',true).':')); ?>
	</fieldset>
	<?php foreach ($permissions as $controller => $actions) : $j++; $i = 0; ?>
<<<<<<< HEAD:app/views/roles/admin_edit.ctp
		<fieldset class="half <?php echo ($j%2) ? 'left' : 'right'; ?>" >
=======
		<fieldset class="half <?php echo ($j % 2) ? 'left' : 'right'; ?>" >
>>>>>>> d0c12d46f0ede68e845d71a28751a308ba8a3e26:app/views/roles/admin_edit.ctp
			<legend class="iconic <?php echo low($controller); ?>">
				<?php echo __(Inflector::humanize($controller),true); //@todo valid i18n? ?>
			</legend>
			<div class="half">
			<?php
			$numActions = count($actions);
			foreach ($actions as $action => $checked) {
				$i++;
				if ($numActions > 1 && $i > $numActions / 2) {
					$i = 0;
					echo '</div>';
					echo '<div class="half">';
				}

				echo $form->input('permissions.' . $controller . ':' . $action, array(
<<<<<<< HEAD:app/views/roles/admin_edit.ctp
					'label' => str_replace('Admin ','',Inflector::humanize($action)),
=======
					'label' => str_replace('Admin ', '', Inflector::humanize($action)),
>>>>>>> d0c12d46f0ede68e845d71a28751a308ba8a3e26:app/views/roles/admin_edit.ctp
					'type' => 'checkbox', 'value' => '',
					'checked' => $checked ? 'checked' : ''
				));
			}
			echo '</div>';
			?>
		</fieldset>
	<?php endforeach; ?>
	<div class="spacer"></div>
	<?php echo $form->end('Save'); ?>
<<<<<<< HEAD:app/views/roles/admin_edit.ctp
</div>
=======
</div>
>>>>>>> d0c12d46f0ede68e845d71a28751a308ba8a3e26:app/views/roles/admin_edit.ctp
