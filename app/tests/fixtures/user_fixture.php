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
			'first_name' => '',
			'last_name' => '0',
			'gender' => '',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
		array(
			'id' => '4a65cf8b-bfc8-4c87-b27d-4d1fa7f05a6e',
			'name' => 'Tim Koschuetzki',
			'login' => 'tim@debuggable.com',
			'password' => 'dcc7ad428afbf7ebc069c434347141190a215d64',
			'active' => '1',
			'level' => 'admin',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'referral_key' => '',
			'first_name' => 'Tim',
			'last_name' => 'Koschuetzki',
			'gender' => 'male',
			'locale' => '5',
			'has_donated' => '0',
			'created' => '2009-05-13 19:36:31',
			'modified' => '2009-05-13 21:44:13',
		),
	);
}

?>