<?php
class GiftType extends AppModel {
	var $hasMany = array(
		'GiftTypesOffice' => array(
			'dependent' => true
		),
		'Gift'
	);
}
?>