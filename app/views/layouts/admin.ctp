<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $html->charset()."\n"; ?>
  <title><?php __('Greenpeace - Cool IT Challenge'); ?> » <?php echo $title_for_layout; ?></title>
<?php echo $this->renderElement("public/header/banner"); ?>
  <?php foreach($css as $sheet) e($html->css($sheet)."\n  "); ?>
<?php foreach($js as $scrpt) e($javascript->link($scrpt)."\n  "); ?>
<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<div id="container">
  <div id="header">
    <h1><?php 
      echo $html->link( $html->image("logo.jpg", array("alt"=>"greenpeace")) ." | ".__("International",array(false)), 
              '/admin/home', array('escape' => 
false)); ?> 
    </h1>
    <ul id="menu">
      <li><a href="<?= Router::Url("/admin/home",true) ?>"  <?php if(isset($this->viewVars["page"]) && $this->viewVars["page"]=="admin_home") echo 'class="selected"'?>><?= __("Home"); ?></li>
      <li><a href="<?= Router::Url("/admin/challenges/index",true) ?>" <?php if($this->name=="Challenges") echo 'class="selected"';?>><?= __("Challenges");?></a></li>
      <li><a href="<?= Router::Url("/admin/criteria/index",true) ?>" <?php if($this->name=="Criteria") echo 'class="selected"';?>><?= __("Rules");?></a></li>
      <li><a href="<?= Router::Url("/admin/leaders/index",true) ?>" <?php if($this->name=="Leaders") echo 'class="selected"';?>><?= __("Leaders");?></a></li>
      <li><a href="<?= Router::Url("/admin/posts/index",true) ?>" <?php if($this->name=="Posts") echo 'class="selected"';?>><?= __("Posts");?></a></li>
      <li><a href="<?= Router::Url("/admin/users/index",true) ?>" <?php if($this->name=="Users") echo 'class="selected"';?>><?= __("Users");?></a></li>
      <li><a href="<?= Router::Url("/admin/logout",true) ?>" class="logout"><?= __("Logout");?></a></li>
    </ul>
    <div id="search">
      <?php echo $form->create('search',array('action' => 'search','id'=>'search'))."\n";?>
      <?php echo $form->input('search')."\n";?>
      <?php echo $form->end('Submit')."\n";?>
    </div>
  </div>
  <div id="content_wrapper">
  <div id="content">
	<?php echo $this->element('messages'); ?>
<?php echo $content_for_layout; ?>
  </div>
  </div>
  <?php echo $this->element('footer') ?>
</div>
<?php echo $this->element('analytics') ?>
<?php echo $cakeDebug; ?>
</body>
</html>
