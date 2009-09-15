<?php
if (isset($jsonVars)):
	echo $javascript->codeBlock('window.jsonVars = '.$javascript->object($jsonVars).';')."\n";
endif;

$inclusionRules = Configure::read('JsIncludes');
$jsIncludes = array();

$controller = @$this->params['controller'];
$action = @$this->params['action'];

$camelController = Inflector::camelize($controller);

$isGuest = User::is('guest');
$noNeedTinyInProfile = $this->name == 'Users' && $this->action == 'person' && $show != 'slideshow' && $show != 'post_view';
foreach ($inclusionRules as $include => $rules) {
	if (Common::requestAllowed($camelController, $action, $rules)) {
		$isTiny = (strpos($include, 'tiny_mce') !== false || strpos($include, 'tiny_initializer') !== false);
		if (($isGuest || $noNeedTinyInProfile) && $isTiny) {
			continue;
		}
		$jsIncludes[] = $include;
	}
}

$viewFile = JS.'views'.DS.'layouts'.DS.$this->layout.'.js';
if (file_exists($viewFile)) {
	$jsIncludes[] = 'views/layouts/'.$this->layout.'.js';
}

$viewFile = JS.'views'.DS.$controller.DS.$action.'.js';
if (file_exists($viewFile)) {
	$jsIncludes[] = 'views/'.$controller.'/'.$action.'.js';
}

if (Common::isDevelopment()) {
	foreach ($jsIncludes as $include) {
		echo "  ".$javascript->link($include)."\n";
	}
	return;
}

$buffer = '';
$includesTinyMce = false;
foreach ($jsIncludes as $include) {
	if (strpos($include, 'tiny_mce') !== false) {
		$includesTinyMce = $include;
	}
	$buffer .= $include;
}

$gitVersion = Common::gitVersion();
$buffer .= $gitVersion;

if (!is_dir(JS . 'aggregate' . DS . $gitVersion)) {
	Common::deleteFilesInDir(JS . 'aggregate', '.*');
	@mkdir(JS . 'aggregate' . DS . $gitVersion);
	@chmod(JS . 'aggregate' . DS . $gitVersion, 0755);
}
$fileName = 'aggregate' . DS . $gitVersion . DS . md5($buffer) . '.js';

if (!file_exists(JS . $fileName)) {
	fopen(JS . $fileName, 'w+');
	$buffer = '';
	foreach ($jsIncludes as $include) {
		if (strpos($include, 'tiny_mce') !== false) {
			echo "  ".$javascript->link($include)."\n";
		} else {
			$buffer .= file_get_contents(JS.$include) .";\n\n";
		}
	}
	file_put_contents(JS . $fileName, $buffer);
} elseif ($includesTinyMce) {
	echo "  ".$javascript->link($includesTinyMce)."\n";
}
echo "  ".$javascript->link($fileName)."\n";
?>