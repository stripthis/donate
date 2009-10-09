<?php

class AppealsTemplateFixture extends CakeTestFixture {
	var $name = 'AppealsTemplate';
	var $records = array(
	/* Some UUID for your convenience
		4acf3d56-20c8-4d6e-841d-3c7c7f000102
		4acf3d56-2a8c-4dcb-a8ca-3c7c7f000102
		4acf3d56-3450-474d-9206-3c7c7f000102
		4acf3d56-3e14-471a-9a52-3c7c7f000102
		4acf3d56-47d8-4931-89d2-3c7c7f000102
		4acf3d56-519c-4a12-b145-3c7c7f000102
		4acf3d56-5afc-4a00-8571-3c7c7f000102
	 */
		array(
			'id' => '4acf3d56-fb48-40f6-aaeb-3c7c7f000102',
			'appeal_id' => '4a686dd2-8c64-45a0-99ee-4507a7f05a6e', // default GPI ongoing
			'template_id' => '4acf366a-58f0-4df6-be21-133a7f000102', // default 1 step redirect
		),
		array(
			'id' => '4acf3d56-0c78-4970-a392-3c7c7f000102',
			'appeal_id' => '4a815eff-8a8c-40fa-9b65-72b6a7f05a6e', // test 1
			'template_id' => '', // 2 steps redirect
		),
		array(
			'id' => '4acf3d56-1704-4584-ac13-3c7c7f000102',
			'appeal_id' => '4aa561f8-d4a8-477a-b66f-4cd3a7f05a6e', // test 2
			'template_id' => '4acf366a-71f0-4d1e-8ea5-133a7f000102', // 1 step direct
		)
	);
}
?>