<?php
class RoleFixture extends CakeTestFixture {
	var $name = 'Role';
	var $records = array(
		array(
			'id' => '4aaf92da-2268-4cf3-ae3d-461aa7f05a6e',
			'name' => 'admin',
			'permissions' => '*:*, !Offices:admin_index, !Offices:admin_add, !Offices:admin_delete, !Users:admin_index, !Bugs:admin_index, !Offices:admin_index, !Roles:*',
			'office_id' => '',
			'created' => '2009-09-28 11:45:00',
			'created_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'modified' => '2009-09-28 11:45:00',
			'modified_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e'
		),
		array(
			'id' => '4aaf92da-5554-49c3-9306-4ad4a7f05a6e',
			'name' => 'guest',
			'permissions' => '!*:admin_*, Auth:admin_login, !Users:delete, !Users:edit, Users:admin_forgot_pw, Users:admin_activate, Pages:display, Gifts:add',
			'office_id' => '',
			'created' => '2009-09-28 11:45:00',
			'created_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'modified' => '2009-09-28 11:45:00',
			'modified_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e'
		),
		array(
			'id' => '4aaf92da-6dcc-4d71-91be-40a9a7f05a6e',
			'name' => 'office_manager',
			'permissions' => '*:*, !Offices:admin_index, !Offices:admin_add, !Offices:admin_delete, !Bugs:admin_index, !Offices:admin_index, !Roles:*',
			'office_id' => '',
			'created' => '2009-09-28 11:45:00',
			'created_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'modified' => '2009-09-28 11:45:00',
			'modified_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e'
		),
		array(
			'id' => '4aaf92da-b930-4da3-9fa8-4909a7f05a6e',
			'name' => 'root',
			'permissions' => '*:*',
			'office_id' => '',
			'created' => '2009-09-28 11:45:00',
			'created_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'modified' => '2009-09-28 11:45:00',
			'modified_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e'
		),
		array(
			'id' => '4aaf92da-d574-4b33-a02f-4566a7f05a6e',
			'name' => 'user',
			'permissions' => '!*:admin_*',
			'office_id' => '',
			'created' => '2009-09-28 11:45:00',
			'created_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'modified' => '2009-09-28 11:45:00',
			'modified_by' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e'
		)
	);
}
?>