<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo Configure::read('App.browserTitle'); ?> Admin <?php echo h($title_for_layout); ?></title>
  <?php echo $this->renderElement("meta_banner"); ?>
  <?php echo $html->charset('utf-8'); ?>
  <link href="/favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
  <base href="<?php echo r('www.', '', Router::url('/', true)); ?>" rel="<?php echo $this->here ?>" />
<?php echo $this->element('css_includes'); ?>
<?php
if (isset($javascript)) {
	echo $this->element('js_includes');
}
echo $scripts_for_layout;
?>
  <meta name="robots" content="noindex,nofollow" />
</head>
<body>
<div id="container">
	<?php echo $this->element('messages')?>
	<div id="header">
		<h1><?php echo $html->image("layout/logo_admin.jpg", array("alt"=>"greenpeace")); ?></h1>
	</div>
	<div id="content_wrapper">
		<?php echo $content_for_layout; ?>
		<div class="sidebar_wrapper">
			<div class="sidebar" id="right_sidebar">
				<?php echo $this->element('admin/sidebar/shortcuts', array('options'=> array('open'=>'open'))); ?>
			</div>
		</div>
	</div>
	<?php echo $this->element('admin/footer'); ?>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>