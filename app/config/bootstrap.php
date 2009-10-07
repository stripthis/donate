<?php
Configure::load('config');
Configure::load('environment');
Configure::load('js_includes');
Configure::load('css_includes');

if (!class_exists('ShellDispatcher')) {
	require_once(APP.'error.php');
}

require_once(APP . 'controllers' . DS . 'components' . DS .'assert.php');
require_once(APP . 'controllers' . DS . 'components' . DS .'common.php');
require_once(APP . 'controllers' . DS . 'components' . DS .'mailer.php');
define('IMPORTS_PATH', WWW_ROOT . 'files' . DS . 'imports' . DS);

function prd($var) {
	pr($var);
	die();
}

function beforeDispatch($controller, $params) {
	if (isset($params['formerror'])) {
		$controller->constructClasses();

		$component = 'Message';
		if (isset($controller->Message->belongsTo)) {
			$component = 'MessageComponent';
		}

		if (!isset($params['formerror-msg'])) {
			$params['formerror-msg'] = 'There are errors that you need to correct';
		}
		$controller->{$component}->add($params['formerror-msg'], 'error');
	}
}


function myClearCache($pattern) {
	App::import('Core', 'Folder');
	$folder = new Folder(CACHE . 'views');
	$files = $folder->find('.*' . $pattern . '.*');

	if (!empty($files)) {
		foreach ($files as $file) {
			$file = r('.php', '', $file);
			clearCache($file);
		}
	}
}

function pluginLoaded($plugin) {
	$App = App::getInstance();
	return isset($App->__map['Plugin'][$plugin]);
}
?>