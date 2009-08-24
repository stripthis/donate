<?php
class Bug extends BugsAppModel{
	var $belongsTo = array('User');

	var $validate = array(
		'bug_descr' => array(
			'rule' => array('minLength', 6)
			, 'message' => 'Please describe what was shown to you as the bug (at least six characters).'
		)
	);
}