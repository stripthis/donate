<?php
$mceRules = 'Gifts:admin_view, Comments:edit';
$config = array(
	'JsIncludes' => array(
		'jquery-1.3.2.min.js' => '*:*',
		'dropdown.js' => '*:admin*',
		'font_resize.js' => '*:admin*',
		'tooltip.js' =>  '*:*',
		'plugins/jquery.state_dropdown.js' => 'Users:register, Users:edit',
		'jquery.validate.js' => 'Users:register',
		// 'jquery.blockUI.js' => '*:*',
		'swfobject.js' => 'Statistics:*',
		'tiny_mce/tiny_mce_gzip.js' => $mceRules,
		'tiny_initializer.js' => $mceRules,
		// main
		'admin_common.js' => '*:admin*',
		'common.js' => '*:!admin*',
		'japp.js' => '*:!admin*',
		'datepicker/jquery.datepick.js' => '*:*',
	)
);
?>