<?php

class OfficeFixture extends CakeTestFixture {
	var $name = 'Office';
	var $records = array(		array(
			'id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'name' => 'International (Level 1)',
			'parent_id' => '',
			'country_id' => '4936948a-f700-4670-9721-4d641030b5da',
			'state_id' => '4936908c-35fc-4a27-95e2-4a391030b5da',
			'city_id' => '4a1161c9-53cc-48c6-8154-80641030b5da',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-07-20 16:29:10',
			'modified' => '2009-08-18 11:45:48',
		),		array(
			'id' => '4a8a6ff2-83cc-4d63-b0dd-2dc8a7f05a6e',
			'name' => 'Med Office (Level 2)',
			'parent_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'country_id' => '',
			'state_id' => '',
			'city_id' => '',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-08-18 11:10:09',
			'modified' => '2009-08-18 11:45:48',
		),		array(
			'id' => '4a8a734a-9154-436e-9157-2da4a7f05a6e',
			'name' => 'France (Level 2)',
			'parent_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'country_id' => '',
			'state_id' => '',
			'city_id' => '',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-08-18 11:24:26',
			'modified' => '2009-08-18 11:45:48',
		),		array(
			'id' => '4a8a766c-9588-44b0-b952-3714a7f05a6e',
			'name' => 'Lebanon Office (Level 3)',
			'parent_id' => '4a8a6ff2-83cc-4d63-b0dd-2dc8a7f05a6e',
			'country_id' => '',
			'state_id' => '',
			'city_id' => '',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-08-18 11:37:48',
			'modified' => '2009-08-18 11:37:48',
		),		array(
			'id' => '4a8a76af-bd4c-4603-8c83-36e8a7f05a6e',
			'name' => 'Belgium Office (Level 2)',
			'parent_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'country_id' => '',
			'state_id' => '',
			'city_id' => '',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-08-18 11:38:55',
			'modified' => '2009-08-18 11:45:48',
		),		array(
			'id' => '4a8a76be-27b8-4da6-b22d-2da4a7f05a6e',
			'name' => 'India Office (Level 2)',
			'parent_id' => '4a6458a6-6ea0-4080-ad53-4a89a7f05a6e',
			'country_id' => '',
			'state_id' => '',
			'city_id' => '',
			'frequencies' => 'onetime,monthly,annualy',
			'amounts' => '5,10,15',
			'created' => '2009-08-18 11:39:10',
			'modified' => '2009-08-18 11:45:48',
		),	);
}

?>