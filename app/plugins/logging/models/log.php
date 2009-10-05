<?php
class Log extends LoggingAppModel {
	var $order = 'created desc';
	var $belongsTo = array('User');
}
?>