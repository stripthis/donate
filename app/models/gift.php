<?php
class Gift extends AppModel {
	var $belongsTo = array(
		'User',
		'Appeal'
	);
}
?>