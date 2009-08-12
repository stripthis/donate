<?php
$mceRules = 'Gifts:admin_view, Comments:edit';
$config = array(
	'JsIncludes' => array(
		'jquery.min.js' => '*:*',
		'common.js' => '*:*',
		'tooltip.js' => '*:*',
		'plugins/jquery.state_dropdown.js' => 'Users:register, Users:edit',
		'jquery.validate.js' => 'Users:register',
		// 'jquery.blockUI.js' => '*:*',
		'japp.js' => '*:*',
		'swfobject.js' => 'Statistics:*',
		'tiny_mce/tiny_mce_gzip.js' => $mceRules,
		'tiny_initializer.js' => $mceRules,
	)
);
?>