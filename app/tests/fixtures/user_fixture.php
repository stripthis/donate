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
			'level' => 'guest',
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
			'level' => 'root',
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