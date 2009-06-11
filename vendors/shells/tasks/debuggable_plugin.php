<?php
if (!class_exists('File')) {
	App::import('Core', 'File');
}
require_once CONSOLE_LIBS.'tasks'.DS.'plugin.php';
class DebuggablePluginTask extends PluginTask {
/**
 * Tasks
 *
 */
	var $tasks = array('DebuggableModel', 'DebuggableController', 'DebuggableView');
}
?>