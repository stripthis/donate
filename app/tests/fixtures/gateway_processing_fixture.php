<?php

class GatewayProcessingFixture extends CakeTestFixture {
	var $name = 'GatewayProcessing';
	var $records = array(		array(
			'id' => '4ae84c23-3ba4-41c1-92b9-3b2ea7f05a6e',
			'label' => 'direct',
			'humanized' => 'Direct',
		),		array(
			'id' => '4ae84c23-8f3c-4133-a115-3b2ea7f05a6e',
			'label' => 'redirect',
			'humanized' => 'Redirect',
		),		array(
			'id' => '4ae84c23-cee8-4f38-b264-3b2ea7f05a6e',
			'label' => 'manual',
			'humanized' => 'Manual',
		),	);
}

?>