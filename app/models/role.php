<?php
class Role extends AppModel {
	var $hasMany = array('User');
	var $unEditable = array('guest', 'root');
}
?>