<?php
$inclusionRules = Configure::read('CssIncludes');
$cssIncludes = array();

$controller = @$this->params['controller'];
$action = @$this->params['action'];

$camelController = Inflector::camelize($controller);

foreach ($inclusionRules as $include => $rules) {
	if (Common::requestAllowed($camelController, $action, $rules)) {
		$cssIncludes[] = $include;
	}
}

$viewFile = CSS.DS.$this->layout.'.css';
if (file_exists($viewFile)) {
	$cssIncludes[] = $this->layout.'.css';
}

$viewFile = CSS . 'views' . DS . $controller . DS . $action . '.css';
if (file_exists($viewFile)) {
	$cssIncludes[] = 'views/' . $controller . '/' . $action . '.css';
}


if (Common::isDevelopment()) {
	foreach ($cssIncludes as $include) {
		echo "  ".$html->css($include)."\n";
	}
	return;
}

$buffer = '';
foreach ($cssIncludes as $include) {
	$buffer .= $include;
}
$gitVersion = Common::gitVersion();
$buffer .= $gitVersion;

if (!is_dir(CSS . 'aggregate' . DS . $gitVersion)) {
	Common::deleteFilesInDir(CSS . 'aggregate', '.*');
	@mkdir(CSS . 'aggregate' . DS . $gitVersion);
	@chmod(CSS . 'aggregate' . DS . $gitVersion, 0755);
}
$fileName = 'aggregate' . DS . $gitVersion . DS . md5($buffer) . '.css';

if (!file_exists(CSS . $fileName)) {
	fopen(CSS . $fileName, 'w+');
	$buffer = '';
	foreach ($cssIncludes as $include) {
		$contents = file_get_contents(CSS . $include);
		$contents = r('(images/', '(../../images/', $contents);
		$buffer .= $contents . "\r\n";
	}
	file_put_contents(CSS . $fileName, $buffer);
}
echo "  ".$html->css(r('.css', '', $fileName)) . "\n";
?>