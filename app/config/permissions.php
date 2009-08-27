<?php
$config = array(
	'App.Permissions' => array(
		'guest' => '!*:admin_*, Auth:admin_login, !Users:delete, !Users:vote, !Users:dashboard, !Users:edit',
		'user' => '!*:admin_*',
		'admin' => '*:*, !Offices:admin_add, !Offices:admin_delete',
		'superadmin' => '*:*, !Offices:admin_add, !Offices:admin_delete',
		'root' => '*:*',
	)
);
?>