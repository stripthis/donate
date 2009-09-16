<div class="content">
<?php
echo $this->element('nav', array(
	  'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
  ));
?>
<h1><?php echo $this->pageTitle = 'Details for ' . $user['User']['login']; ?></h1>
</div>