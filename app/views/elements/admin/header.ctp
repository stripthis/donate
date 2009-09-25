	<div id="header">
		<h1><?php echo $html->image("admin/layout/logo.jpg", array("alt"=>"greenpeace")); ?></h1>
<?php echo $this->element('admin/country_selector'); ?>
<?php echo $this->element('admin/users/badge'); ?>
<?php echo $this->element('nav', array('type' => 'Admin', 'id' => 'menu_top', 'class' => 'menu')); ?>
	</div>
