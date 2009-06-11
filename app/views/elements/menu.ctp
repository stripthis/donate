  <cake:nocache>
    <ul class="nav">
      <li><?php echo $html->link(__('Home', true), "/"); ?></li>
<?php if (User::isAdmin()) : ?>
	    <li><?php echo $html->link('Admin', array('controller' => 'dashboards', 'action' => 'index', 'admin' => true)); ?></li>
<?php endif; ?>
<?php if (!User::isGuest()) : ?>
      <li><?php echo $html->link(__('Dashboard', true),array('controller' => 'users', 'action' => 'dashboard', 'admin' => false)); ?></li>
<?php endif; ?>
      <li><a href="http://www.greenpeace.org/international/campaigns/climate-change/cool-it-challenge/about"><?php echo __('About', true); ?></a></li>
    </ul>
  <cake:nocache>
