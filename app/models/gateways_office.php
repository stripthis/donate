<?php
class GatewayOffice extends AppModel {
	var $belongsTo = array(
		'Office',
		'Gateway'
	);
}
?>