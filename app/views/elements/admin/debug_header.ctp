<div class="debug_header">
	<strong style="color:red;">Beta Test</strong> :
	<?php echo $html->link('Single Form Example', '/')?> | 
	<?php echo $html->link('Multi Step Form Example', '/')?> | 
	<?php
	$url = User::isAdmin() 
			? '/admin/home'
			: array('controller' => 'auth', 'action' => 'login', 'admin' => true);
	echo $html->link('Admin section', $url);
	?>
</div>