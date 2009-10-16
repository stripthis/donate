<?php
class Currency extends AppModel {
	var $hasMany = array(
		'CurrenciesOffice' => array(
			'dependent' => true
		)
	);
}
?>