<?php
class Gateway extends AppModel {
	var $hasAndBelongsToMany = array(
		'Office' => array(
			'with' => 'GatewayOffice'
		)
	);
}
?>