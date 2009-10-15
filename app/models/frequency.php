<?php
class Frequency extends AppModel {
	var $hasMany = array(
		'FrequenciesOffice' => array(
			'dependent' => true
		)
	);
}
?>