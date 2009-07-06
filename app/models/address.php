<?php
class Address extends AppModel {
	var $belongsTo = array(
		'User',
		'Country',
		'State',
		'City'
	);
}
?>