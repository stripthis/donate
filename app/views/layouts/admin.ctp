<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo Configure::read('App.browserTitle'); ?> <?php echo h($title_for_layout); ?></title>
<?php echo $this->element("meta_includes"); ?>
	<base href="<?php echo r('www.', '', Router::url('/', true)); ?>" rel="<?php echo $this->here ?>" />
<?php echo $this->element('css_includes'); ?>
<?php
	if (isset($javascript)) {
		echo $this->element('js_includes');
	}
	echo $scripts_for_layout;
?>
</head>
<body>
<div id="container">
<?php echo $this->element('messages')?>
	<div id="header">
		<h1><?php echo $html->image("admin/layout/logo.jpg", array("alt"=>"greenpeace")); ?></h1>
<?php echo $this->element('admin/country_selector'); ?>
<?php echo $this->element('admin/users/badge'); ?>
<?php echo $this->element('nav', array('type' => 'Admin', 'id' => 'menu_top', 'class' => 'menu')); ?>
	</div>
	<div id="content_wrapper">
		<?php echo $content_for_layout; ?>
		<div class="sidebar_wrapper">
			<?php echo $this->element("admin/sidebar"); ?>
		</div>
	</div>
	<?php echo $this->element("admin/footer"); ?>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>