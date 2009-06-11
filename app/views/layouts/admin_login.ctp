<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $html->charset(); ?>
  <title><?php __('Greenpeace'); ?> <?php echo $title_for_layout; ?></title>
<?php $this->renderElement("public/header/banner"); ?>
<?php foreach($css as $sheet) e($html->css($sheet)."\n  "); ?>
<?php foreach($js as $scrpt) e($javascript->link($scrpt)."\n  "); ?>
<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<div id="container">
  <div id="header">
    <h1><?php 
      echo $html->link( $html->image("logo.jpg", array("alt"=>"greenpeace")) ." | ".__("International",array(false)), 
              '/admin/home', array('escape' => false)); ?></h1>
  </div>
  <div id="content_wrapper">
  <div id="content">
<?php echo $content_for_layout; ?>
  </div>
  </div>
  <div id="footer"> 2009 © Greenpeace International </div>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>
