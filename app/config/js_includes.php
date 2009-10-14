<?php
$mceRules = 'Gifts:admin_view, Comments:edit';
$config = array(
	'JsIncludes' => array(
		'jquery-1.3.2.min.js' => '*:*',
		'dropdown.js' => '*:admin*',
		'font_resize.js' => '*:admin*',
		'tooltip.js' =>  '*:*',
		'plugins/jquery.state_dropdown.js' => 'Users:register, Users:edit',
		'plugins/jquery.hotkeys.min' => '*:admin*',
		'plugins/jquery.scrollTo-min' => '*:admin*',
		'plugins/jquery.chat.js' => '*:admin*',
		'plugins/jquery.segments.js' => '*:admin*',
		'jquery.validate.js' => 'Users:register',
		'swfobject.js' => 'Statistics:*',
		'tiny_mce/tiny_mce_gzip.js' => $mceRules,
		'tiny_initializer.js' => $mceRules,

		'admin_common.js' => '*:admin*',
		'common.js' => '*:!admin*',
		'japp.js' => '*:*',
		'datepicker/jquery.datepick.js' => '*:*',
		'datepicker.js' => '*:*',
		'thickbox.js' => 'Tellfriends:refer, Tellfriends:openinviter',
		'datepick.js' => '*:*'
	)
);
?>