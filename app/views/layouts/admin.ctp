<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo Configure::read('App.browserTitle'); ?> Admin <?php echo h($title_for_layout); ?></title>
  <?php echo $this->renderElement("meta_banner"); ?>
  <?php echo $html->charset('utf-8'); ?>
  <link href="/favicon.ico" type="image/x-icon" rel="icon"/>
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
  <base href="<?php echo r('www.', '', Router::url('/', true)); ?>" rel="<?php echo $this->here ?>" />
<?php //echo $this->element('css_includes'); ?>
  <link rel="stylesheet" type="text/css" href="/css/admin.css" />
<?php
  if (isset($javascript)): 
    echo $this->element('js_includes');
  endif;
  echo $scripts_for_layout;
?>
  <meta name="robots" content="noindex,nofollow" />
</head>
<body>
<div id="container">
<?php echo $this->element('messages')?>
  <div id="header">
    <h1><?php echo $html->image("layout/logo_admin.jpg", array("alt"=>"greenpeace")); ?></h1>
<?php echo $this->element('admin/country_selector'); ?>
<?php echo $this->element('admin/user_badge'); ?>
<?php //echo $this->element('admin/search'); ?>
<?php echo $this->element('admin/menu'); ?>
  </div>
  <div id="content_wrapper">
<?php echo $content_for_layout; ?>
    <div class="sidebar_wrapper">
<?php echo $this->element("admin/sidebar"); ?>
    </div>
	</div>
  <div id="footer">
  	<p><strong>2009 &copy; Greenpeace International</strong>  &#149; v.0.1 (Esperanza)  &#149;</p>
  	<a href="http://www.cakephp.org/" target="_blank" class="cakephpower">
 		  <img src="/img/cake.power.gif" alt="CakePHP(tm) :: Rapid Development Framework">
 		</a>
 	</div>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>
