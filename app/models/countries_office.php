<?php
class CountriesOffice extends AppModel {
	var $belongsTo = array(
		'Office',
		'Country'
	);
}
?>