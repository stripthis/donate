<?php
class GatewaysOffice extends AppModel {
	var $belongsTo = array(
		'Office',
		'Gateway'
	);
}
?>