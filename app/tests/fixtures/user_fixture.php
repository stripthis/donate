<?php

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $records = array(
		array(
			'id' => '4a0b051f-f704-47c3-8200-834323c1de0a',
			'name' => '',
			'login' => 'guest@greenpeace.org',
			'password' => '',
			'active' => '0',
			'role_id' => '4aaf92da-5554-49c3-9306-4ad4a7f05a6e',
			'office_id' => '',
			'referral_key' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
		array(
			'id' => '4aa65fb5-ec64-48ca-a68e-444fa7f05a6e',
			'name' => 'Rémy Bertot',
			'login' => 'rbertot@greenpeace.org',
			'password' => '64f5c51ec88e6076154d6bf871c8abd7c888297e',
			'active' => '1',
			'role_id' => '4aaf92da-b930-4da3-9fa8-4909a7f05a6e',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'referral_key' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
		array(
			'id' => '4aaff7bb-f8b0-4cc0-b754-1039a7f05a6e',
			'name' => 'Superadmin User',
			'login' => 'superadmin@greenpeace.org',
			'password' => 'd11df5c4311bb68cb81c4c205c7fa9a3e08b4d79', // test
			'active' => '1',
			'role_id' => '4aaf92da-6dcc-4d71-91be-40a9a7f05a6e',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'referral_key' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
		array(
			'id' => '4aaff7bb-7d1c-4cf2-bf8f-1039a7f05a6e',
			'name' => 'Admin User',
			'login' => 'admin@greenpeace.org',
			'password' => 'd11df5c4311bb68cb81c4c205c7fa9a3e08b4d79', // test
			'active' => '1',
			'role_id' => '4aaf92da-2268-4cf3-ae3d-461aa7f05a6e',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'referral_key' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
		array(
			'id' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e',
			'name' => 'Root User',
			'login' => 'root@greenpeace.org',
			'password' => 'd11df5c4311bb68cb81c4c205c7fa9a3e08b4d79', // test
			'active' => '1',
			'role_id' => '4aaf92da-b930-4da3-9fa8-4909a7f05a6e',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'referral_key' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		)
	);
}

?>