<?php

$config = array(
	'App.Permissions' => array(
		'guest' => '!*:admin_*, Auth:admin_login, !Users:delete, !Users:vote, !Users:dashboard, !Users:edit',
		'user' => '!*:admin_*',
		'admin' => '*:*',
	)
);

?>