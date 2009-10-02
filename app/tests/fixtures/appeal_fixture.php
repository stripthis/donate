<?php

class AppealFixture extends CakeTestFixture {
	var $name = 'Appeal';
	var $records = array(		array(
			'id' => '4a686dd2-8c64-45a0-99ee-4507a7f05a6e',
			'parent_id' => '',
			'appeal_step_count' => '1',
			'name' => 'default GPI appeal',
			'slug' => 'support_us',
			'campaign_code' => 'code',
			'default' => '1',
			'cost' => '200',
			'reviewed' => '1',
			'status' => 'published',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'user_id' => '4a65cf8b-bfc8-4c87-b27d-4d1fa7f05a6e',
			'created' => '2009-07-23 16:04:02',
			'modified' => '2009-07-23 16:05:31',
		),
		array(
			'id' => '4a815eff-8a8c-40fa-9b65-72b6a7f05a6e',
			'parent_id' => '',
			'appeal_step_count' => '2',
			'name' => 'New Example Appeal',
			'slug' => '',
			'campaign_code' => 'appeal_2',
			'default' => '0',
			'cost' => '200',
			'reviewed' => '1',
			'status' => 'published',
			'office_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'user_id' => '4a65cf8b-bfc8-4c87-b27d-4d1fa7f05a6e',
			'created' => '2009-08-11 14:07:27',
			'modified' => '2009-08-11 14:07:27',
		),
		array(
			'id' => '4aa561f8-d4a8-477a-b66f-4cd3a7f05a6e',
			'parent_id' => '',
			'appeal_step_count' => '2',
			'name' => 'Not Live Appeal',
			'slug' => '',
			'campaign_code' => 'appeal_2',
			'default' => '0',
			'cost' => '200',
			'reviewed' => '1',
			'status' => 'published',
			'office_id' => '4a8a76be-27b8-4da6-b22d-2da4a7f05a6e',
			'user_id' => '4a65cf8b-bfc8-4c87-b27d-4d1fa7f05a6e',
			'created' => '2009-08-11 14:07:27',
			'modified' => '2009-08-11 14:07:27',
		)
	);
}

?>