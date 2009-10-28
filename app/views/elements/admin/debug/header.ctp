<?php if (!User::is('guest')) : ?>
<div class="debug_header_wrapper">
<div class="debug_header">
	<p><?php echo __('Welcome back')?> <strong><?php echo User::get('name'); ?></strong> (<?php echo Inflector::humanize(User::get('Role.name')); ?>): 
		<a href="<?php echo Router::Url('/admin/users/preferences',true) ?>" class="profile"><?php echo __('preferences',true);?></a>&nbsp;|&nbsp;
		<a href="<?php echo Router::Url('/admin/auth/logout',true) ?>" class="logout"><?php echo __('logout',true);?></a>
		- &nbsp;
	</p>
	<p><?php echo __('Select an appeal'); ?>:</p>
	<div class="appeal_switch">
	<?php 
		//@todo v0.2 make it dynamic 
		$appealOptions = array(
			'Published' => array(
				'4a686dd2-8c64-45a0-99ee-4507a7f05a6e' => 'Default GPI - 1 step redirect',
				'4a815eff-8a8c-40fa-9b65-72b6a7f05a6e' => 'GPI Test - 2 step redirect'
			),
			'Draft' => array(
				'4aa561f8-d4a8-477a-b66f-4cd3a7f05a6e' => 'GPI Test - 1 step direct'
			)
		);
	?>
	<?php echo $form->create('Appeal', array('url' => $html->url(
		array('controller' => 'appeals','action'=>'redirect','admin' => true))
	))."\n"; ?>
	<?php echo $form->input('Appeal.id', array('options' => $appealOptions, 'label' => false))."\n"; 	?>
	<?php echo $form->submit(__('go »',true))."\n"; ?>
	<?php echo $form->end()."\n"; ?>
	</div>
</div>
</div>
<?php endif; ?>
