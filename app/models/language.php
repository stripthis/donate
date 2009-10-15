<?php
class Language extends AppModel {
	var $hasMany = array(
		'LanguagesOffice' => array(
			'dependent' => true
		)
	);
}
?>