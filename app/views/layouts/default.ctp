<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo Configure::read('App.browserTitle'); ?> <?php echo h($title_for_layout); ?></title>
	<?php echo $this->element("meta_includes"); ?>
	<?php echo $html->charset('utf8'); ?>
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
<?php echo $this->element('admin/debug/header'); ?>
<div id="container">
<?php echo $content_for_layout; ?>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>