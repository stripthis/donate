<?php
class Import extends AppModel {
	var $belongsTo = array('User');

	var $validate = array(
		'serial' => array(
			'required' => array('rule' => 'notEmpty', 'message' => 'Please enter a serial.')
		)
		, 'description' => array(
			'rule' => 'notEmpty', 'message' => 'Please insert a valid description.'
		)
	);
}
?>