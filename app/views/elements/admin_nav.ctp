<ul id="admin-nav">
	<li><?php echo $html->link('Settings', array('controller' => 'settings', 'action' => 'edit'))?></li>
	<li><?php echo $html->link('Users', array('controller' => 'users', 'action' => 'index'))?></li>
	<li><?php echo $html->link('Leaders', array('controller' => 'leaders', 'action' => 'index'))?></li>
	<li><?php echo $html->link('Leader Score History', array('controller' => 'leaders', 'action' => 'score_history'))?></li>
	<li><?php echo $html->link('Posts', array('controller' => 'posts', 'action' => 'index'))?></li>
	<li><?php echo $html->link('Criteria', array('controller' => 'criteria', 'action' => 'index'))?></li>
</ul>