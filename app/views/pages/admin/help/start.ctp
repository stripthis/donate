<div class="content help" id="admin_help_start">
	<h1><?php echo __('Help', true); ?></h1>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_help_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<p class="empty"><?php echo __('Coming soon...', true); ?></p>
</div>