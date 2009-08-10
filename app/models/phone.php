<?php
class Phone extends AppModel {
	var $belongsTo = array(
		'Contact',
		'Address'
	);
}
?>