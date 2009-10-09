<?php

class TemplateFixture extends CakeTestFixture {
	var $name = 'Template';
	var $records = array(
	/* Default
		  Some UUID for your convenience
				4acf366a-8f3c-4e80-b402-133a7f000102
				4acf366a-9900-45b9-a4ff-133a7f000102
				4acf366a-a2c4-4d4c-9028-133a7f000102
				4acf366a-ac88-4cc5-a100-133a7f000102
				4acf366a-b5e8-4147-9e0e-133a7f000102
		array(
			'id' => '',					// UUID
			'name' => '',
			'lang' => '',
			'step_count' => '',
			'processing' => '', // redirect, direct, manual
			'created' => '',
			'created_by' => '', // UUID
			'modified' => '',
			'modified_by' => ''
		)*/
		array(
			'id' => '4acf366a-58f0-4df6-be21-133a7f000102',
			'name' => 'Generic - one step redirect',
			'lang' => 'ENG',
			'step_count' => '1',
			'processing' => 'redirect',
			'created' => '2009-10-09 15:00:00',
			'created_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e', //root
			'modified' => '2009-10-09 15:00:00',
			'modified_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e'
		),
		array(
			'id' => '4acf366a-67c8-42ef-b701-133a7f000102',
			'name' => 'Generic - two steps redirect',
			'lang' => 'ENG',
			'step_count' => '2',
			'processing' => 'redirect',
			'created' => '2009-10-09 15:00:00',
			'created_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e',
			'modified' => '2009-10-09 15:00:00',
			'modified_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e'
		),
		array(
			'id' => '4acf366a-71f0-4d1e-8ea5-133a7f000102',
			'name' => 'Generic - one step direct',
			'lang' => 'ENG',
			'step_count' => '1',
			'processing' => 'direct',
			'created' => '2009-10-09 15:00:00',
			'created_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e',
			'modified' => '2009-10-09 15:00:00',
			'modified_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e'
		)/*,
		array(
			'id' => '4acf366a-7bb4-4eb4-acb0-133a7f000102',
			'name' => 'Generic - two steps direct',
			'lang' => 'ENG',
			'step_count' => '1',
			'created' => '2009-10-09 15:00:00',
			'created_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e',
			'modified' => '2009-10-09 15:00:00',
			'modified_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e'
		),
		array(
			'id' => '4acf366a-8578-4876-827b-133a7f000102',
			'name' => 'Generic - three steps direct',
			'lang' => 'ENG',
			'step_count' => '1',
			'created' => '2009-10-09 15:00:00',
			'created_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e',
			'modified' => '2009-10-09 15:00:00',
			'modified_by' => '4aaff7bb-bebc-4ca4-9577-1039a7f05a6e'
		)*/
	);
}
?>