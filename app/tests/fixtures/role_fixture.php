<?php
class RoleFixture extends CakeTestFixture {
	var $name = 'Role';
	var $records = array(
		array(
			'id' => '4aaf92da-2268-4cf3-ae3d-461aa7f05a6e',
			'name' => 'admin',
			'permissions' => '*:*, !Offices:admin_add, !Offices:admin_delete, !Users:admin_index, !Bugs:admin_index, !Offices:admin_index, !Roles:*',
		),
		array(
			'id' => '4aaf92da-5554-49c3-9306-4ad4a7f05a6e',
			'name' => 'guest',
			'permissions' => '!*:admin_*, Auth:admin_login, !Users:delete, !Users:vote, !Users:dashboard, !Users:edit, Users:admin_forgot_pw',
		),
		array(
			'id' => '4aaf92da-6dcc-4d71-91be-40a9a7f05a6e',
			'name' => 'superadmin',
			'permissions' => '*:*, !Offices:admin_add, !Offices:admin_delete, !Users:admin_index, !Bugs:admin_index, !Offices:admin_index, !Roles:*',
		),
		array(
			'id' => '4aaf92da-b930-4da3-9fa8-4909a7f05a6e',
			'name' => 'root',
			'permissions' => '*:*',
		),
		array(
			'id' => '4aaf92da-d574-4b33-a02f-4566a7f05a6e',
			'name' => 'user',
			'permissions' => '!*:admin_*',
		)
	);
}

?>