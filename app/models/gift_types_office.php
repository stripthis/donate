<?php
class GiftTypesOffice extends AppModel {
	var $belongsTo = array(
		'GiftType',
		'Office'
	);
}
?>