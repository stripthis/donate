<ul id="admin-nav">
	<li><?php echo $html->link('Settings', array('controller' => 'settings', 'action' => 'edit'))?></li>
	<li><?php echo $html->link('Statistics', array('controller' => 'statistics', 'action' => 'index'))?></li>
	<li><?php echo $html->link('Users', array('controller' => 'users', 'action' => 'index'))?></li>
	<li><?php echo $html->link('Posts', array('controller' => 'posts', 'action' => 'index'))?></li>
</ul>