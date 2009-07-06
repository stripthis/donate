<?php
class Office extends AppModel {
	var $hasAndBelongsToMany = array(
		'Gateway' => array(
			'with' => 'GatewayOffice'
		)
	);
}
?>