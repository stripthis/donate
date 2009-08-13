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
  <div id="header">
    <h1><?php 
      echo $html->link( $html->image("layout/logo_admin.jpg", array("alt"=>"greenpeace")) ." | ".__("International",array(false)), 
              '/admin/dashboard', array('escape' => false)); ?>
	<?php echo ' | Logged in as: ' . User::get('login'); ?>
    </h1>
    <ul id="menu">
      <li><a href="<?php echo Router::Url("/admin/home",true) ?>"  <?php if(isset($this->viewVars["page"]) && $this->viewVars["page"]=="admin_home") echo 'class="selected"'?>><?php echo __("Home"); ?></li>
      <li><a href="<?php echo Router::Url("/admin/appeals/index",true) ?>" <?php if($this->name=="Appeals") echo 'class="selected"';?>><?php echo __("Appeals");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/gifts/index",true) ?>" <?php if($this->name=="Gifts") echo 'class="selected"';?>><?php echo __("Gifts");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/transactions/index",true) ?>" <?php if($this->name=="Transactions") echo 'class="selected"';?>><?php echo __("Transactions");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/supporters/index",true) ?>" <?php if($this->name=="Supporters") echo 'class="selected"';?>><?php echo __("Supporters");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/offices/edit/" . Configure::read('Office.id'),true) ?>" <?php if($this->name=="Config") echo 'class="selected"';?>><?php echo __("Config");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/auth/logout",true) ?>" class="logout"><?php echo __("Logout");?></a></li>
    </ul>
    <div id="search">
      <?php echo $form->create('search',array('action' => 'search','id'=>'search'))."\n";?>
      <?php echo $form->input('search')."\n";?>
      <?php echo $form->end('Submit')."\n";?>
    </div>
  </div>
  <div id="right">
	<h3>Current Office</h3>
	<?php
	echo Configure::read('Office.name') . '<br />';
	$parent = Configure::read('Office.ParentOffice');

	if (!empty($parent)) {
		$parent = AppModel::normalize('Office', $parent);
		echo $html->link('Back to ' . $parent['Office']['name'], array(
			'controller' => 'offices', 'action' => 'activate', $parent['Office']['id']
		));
	}
	?>
	
	<h3>Available Child Offices</h3>
	<?php
	$subOffices = Configure::read('Office.SubOffice');
	if (empty($subOffices)) {
		echo '<p>' . __('The office has no suboffices.', true);
	} else {
		echo '<ul>';
		foreach ($subOffices as $office) {
			$office = AppModel::normalize('Office', $office);
			echo '<li>' . $html->link('Activate ' . $office['Office']['name'], array(
				'controller' => 'offices', 'action' => 'activate', $office['Office']['id']
			)) . '</li>';
		}
		echo '</ul>';
	}
	?>
  </div>
  <div id="content_wrapper">
	<?php echo $this->element('messages')?>
<?php echo $content_for_layout; ?>
  </div>
</div>
<?php echo $cakeDebug; ?>
</body>
</html>
