<!-- HEADER -->
<div id="header">
	<h1>
		<a href="<?php echo Router::url('/admin/home'); ?>"><?php echo $html->image("admin/layout/logo.jpg", array("alt"=>"greenpeace")); ?></a>
	</h1>

	<?php
	if (!User::is('guest')) {
		echo $this->element('admin/country_selector');
		echo $this->element('admin/users/badge');
		echo $this->element('nav', array('type' => 'Admin', 'id' => 'menu_top', 'class' => 'menu'));
	}
	?>
</div>