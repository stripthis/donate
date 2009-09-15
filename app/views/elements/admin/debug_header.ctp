<div class="debug_header">
	<strong style="color:red;">Beta Test</strong> :
	<?php echo $html->link('Single Form Example', 'https://donate.greenpeace.org/gifts/add/office_id:4a8a734a-9154-436e-9157-2da4a7f05a6e')?> | 
	<?php echo $html->link('Multi Step Form Example', 'https://donate.greenpeace.org/gifts/add/office_id:4a6458a6-6ea0-4080-ad53-4a89a7f05a6e')?> | 
	<?php
	$url = !User::is('guest') 
			? '/admin/home'
			: array('controller' => 'auth', 'action' => 'login', 'admin' => true);
	echo $html->link('Admin section', $url);
	?>
</div>