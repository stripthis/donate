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
		<fieldset class="half <?php echo ($j % 2) ? 'left' : 'right'; ?>" >
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
					'label' => str_replace('Admin ', '', Inflector::humanize($action)),
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
</div>
