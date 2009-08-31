<?php
$config = array(
	'App.Permissions' => array(
		'guest' => '!*:admin_*, Auth:admin_login, !Users:delete, !Users:vote, !Users:dashboard, !Users:edit',
		'user' => '!*:admin_*',
		'admin' => '*:*, !Offices:admin_add, !Offices:admin_delete, !Users:admin_index, !Bugs:admin_index, !Offices:admin_index',
		'superadmin' => '*:*, !Offices:admin_add, !Offices:admin_delete, !Users:admin_index, !Bugs:admin_index, !Offices:admin_index',
		'root' => '*:*',
	)
);
?>