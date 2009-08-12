<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title><?php echo Configure::read('App.browserTitle'); ?> <?php echo h($title_for_layout); ?></title>
  <?php echo $this->renderElement("meta_banner"); ?>
  <?php echo $html->charset('utf-8'); ?>
  <link href="/favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
  <base href="<?php echo r('www.', '', Router::url('/', true)); ?>" rel="<?php echo $this->here ?>" />
<?php echo $this->element('css_includes'); ?>
  <!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="/css/msie.css" /><![endif]-->
<?php
  if (isset($javascript)): 
    echo $this->element('js_includes');
  endif;
  echo $scripts_for_layout;
?>
</head>
<body>
<?php echo $this->element('admin/debug_header') ?>
<div id="container">
<?php echo $content_for_layout; ?>
</div>
<?php echo $this->element('analytics') ?>
<?php echo $cakeDebug; ?>
</body>
</html>