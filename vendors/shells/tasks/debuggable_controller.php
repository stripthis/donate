<?php
require_once CONSOLE_LIBS.'tasks'.DS.'controller.php';
class DebuggableControllerTask extends ControllerTask {
	var $yesResponses = array('y');
	var $noResponses = array('n');
/**
 * Interactive
 *
 * @access private
 */
	function __interactive($controllerName = false) {
		$responses = am($this->yesResponses, $this->noResponses);
		if (!$controllerName) {
			$this->interactive = true;
			$this->hr();
			$this->out(sprintf("Bake Controller\nPath: %s", $this->path));
			$this->hr();
			$actions = '';
			$uses = array();
			$wannaDoAdmin = 'y';
			$wannaUseScaffold = 'n';
			$wannaDoScaffolding = 'y';
			$controllerName = $this->getName();
		}
		$this->hr();
		$this->out("Baking {$controllerName}Controller");
		$this->hr();

		$controllerFile = low(Inflector::underscore($controllerName));

		$question[] = __('Would you like to build your controller interactively?', true);
		if (file_exists($this->path . $controllerFile .'_controller.php')) {
			$question[] = sprintf(__("Warning: Choosing no will overwrite the %sController.", true), $controllerName);
		}
		$doItInteractive = $this->in(join("\n", $question), $responses, 'y');
		if (in_array($doItInteractive, $this->yesResponses)) {
			$this->interactive = true;

			$wannaUseScaffold = $this->in(__("Would you like to use scaffolding?", true), $responses, 'n');
			$wannaDoScaffolding = 'n';
			if (in_array($wannaUseScaffold, $this->noResponses)) {
				$wannaDoScaffolding = $this->in(__("Would you like to include some basic class methods (index(), add(), view(), edit())?", true), $responses, 'y');
				if (in_array($wannaDoScaffolding, $this->yesResponses)) {
					$wannaDoAdmin = $this->in(__("Would you like to create the methods for admin routing?", true), $responses, 'y');
				}
			}
		} else {
			$wannaDoScaffolding = $this->in(__("Would you like to include some basic class methods (index(), add(), view(), edit())?", true), $responses, 'y');
			if (in_array($wannaDoScaffolding, $this->yesResponses)) {
				$wannaDoAdmin = $this->in(__("Would you like to create the methods for admin routing?", true), $responses, 'y');
			}
		}
		$admin = false;

		if (in_array($wannaDoAdmin, $this->yesResponses)) {
			$admin = $this->getAdmin();
		}

		if (in_array($wannaDoScaffolding, $this->yesResponses)) {
			$actions = $this->bakeActions($controllerName, null, false);
			if ($admin) {
				$actions .= $this->bakeActions($controllerName, $admin, false);
			}
		}

		if ($this->interactive === true) {
			$this->out('');
			$this->hr();
			$this->out('The following controller will be created:');
			$this->hr();
			$this->out("Controller Name:  $controllerName");

			if (in_array($wannaUseScaffold, $this->yesResponses)) {
				$this->out("		   var \$scaffold;");
				$actions = 'scaffold';
			}
			$this->hr();

			$looksGood = $this->in(__('Look okay?', true), $responses, 'y');
			if (in_array($looksGood, $this->yesResponses)) {
				$baked = $this->bake($controllerName, $actions, array(), array(), $uses);
				if ($baked && $this->_checkUnitTest()) {
					$this->bakeTest($controllerName);
				}
			} else {
				$this->__interactive($controllerName);
			}
			return;
		}

		$baked = $this->bake($controllerName, $actions, array(), array(), $uses);
		if ($baked && $this->_checkUnitTest()) {
			$this->bakeTest($controllerName);
		}
	}
/**
 * Bake scaffold actions
 *
 * @param string $controllerName Controller name
 * @param string $admin Admin route to use
 * @param boolean $wannaUseSession Set to true to use sessions, false otherwise
 * @return string Baked actions
 * @access private
 */
	function bakeActions($controllerName, $admin = null, $wannaUseSession = true) {
		$currentModelName = $this->_modelName($controllerName);
		if (!App::import('Model', $currentModelName)) {
			$this->err(__('You must have a model for this class to build scaffold methods. Please try again.', true));
			exit;
		}

		$modelObj =& ClassRegistry::init($currentModelName);
		$controllerPath = $this->_controllerPath($controllerName);
		$pluralName = $this->_pluralName($currentModelName);
		$singularName = Inflector::variable($currentModelName);
		$singularHumanName = Inflector::humanize($currentModelName);
		$pluralHumanName = Inflector::humanize($controllerName);
		$displayField = $modelObj->displayField;

		$schema = $modelObj->schema();
		$orderName = array_key_exists('name', $schema) 
				? 'name' 
				: $modelObj->primaryKey;
		$containments = '';

		$actions = null;

		/* INDEX ACTION */
		$actions = <<<PHP
/**
 * index action
 *
 * @return void
 * @access public
 */
	function {$admin}index() {
		\$this->paginate['{$currentModelName}']['order'] = array('{$currentModelName}.{$orderName}' => 'asc');
		\${$pluralName} = \$this->paginate(\$this->{$currentModelName});
		\$this->set(compact('{$pluralName}'));
	}
/**
 * view action
 *
 * @param string \$id the {$singularName} id
 * @return void
 * @access public
 */
	function {$admin}view(\$id = null) {
		\${$singularName} = \$this->{$currentModelName}->find('first', array(
			'conditions' => array('{$currentModelName}.id' => \$id),
			'contain' => false
		));
		Assert::notEmpty(\${$singularName}, '404');
		\$this->set(compact('{$singularName}'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function {$admin}add() {
		\$this->{$admin}edit();
	}
/**
 * undocumented function
 *
 * @param string \$id 
 * @return void
 * @access public
 */
	function {$admin}edit(\$id = null) {
		\${$singularName} = \$this->{$currentModelName}->create();
		\$action = 'add';
		if (\$this->action == '{$admin}edit') {
			\${$singularName} = \$this->{$currentModelName}->find('first', array(
				'conditions' => array(
					'{$currentModelName}.id' => \$id
				),
				'contain' => false,
			));
			Assert::notEmpty(\${$singularName}, '404');
			\$action = 'edit';
		}
PHP;

		$compact = array();
		foreach ($modelObj->hasAndBelongsToMany as $associationName => $relation) {
			if (!empty($associationName)) {
				$habtmModelName = $this->_modelName($associationName);
				$habtmSingularName = $this->_singularName($associationName);
				$habtmPluralName = $this->_pluralName($associationName);
				$actions .= "\n\t\t\${$habtmPluralName} = \$this->{$currentModelName}->{$habtmModelName}->find('list');\n";
				$compact[] = "'{$habtmPluralName}'";
			}
		}
		foreach ($modelObj->belongsTo as $associationName => $relation) {
			if (!empty($associationName)) {
				$belongsToModelName = $this->_modelName($associationName);
				$belongsToPluralName = $this->_pluralName($associationName);
				$actions .= "\n\t\t\${$belongsToPluralName} = \$this->{$currentModelName}->{$belongsToModelName}->find('list');\n";
				$compact[] = "'{$belongsToPluralName}'";
			}
		}

		$compact[] = 'action';
		$buffer = '';
		foreach ($compact as $c) {
			$buffer = "'{$c}', ";
		}
		$compact = substr($buffer, 0, -2);

		$actions .= <<<PHP

		\$this->set(compact({$compact}));
		\$this->action = '{$admin}edit';
		if (\$this->isGet()) {
			return \$this->data = \${$singularName};
		}

		if (\$action == 'add') {
			\$this->data['{$currentModelName}']['user_id'] = User::get('id');
		}

		\$this->{$currentModelName}->set(\$this->data['{$currentModelName}']);
		\$result = \$this->{$currentModelName}->save();
		if (\$this->{$currentModelName}->validationErrors) {
			return \$this->Message->add(__('Please fill out all fields', true), 'error');
		}
		Assert::notEmpty(\$result);

		\$msg = __('{$currentModelName} was saved successfully.', true);
		if (\$action == 'add') {
			\$url = array('action' => '{$admin}edit', \$this->{$currentModelName}->id);
			return \$this->Message->add(\$msg, 'ok', true, \$url);
		}
		\$this->Message->add(\$msg, 'ok', true, array('action' => '{$admin}index'));
	}
/**
 * delete action
 *
 * @param string \$id the {$singularName} id
 * @param boolean if the {$singularName} should be deleted or undeleted
 * @return void
 * @access public
 */
	function {$admin}delete(\$id = null, \$undelete = false) {
		\${$singularName} = \$this->{$currentModelName}->find('first', array(
			'conditions' => compact('id'),
			'contain' => false
		));
		Assert::notEmpty(\${$singularName}, '404');
		Assert::true(AppModel::isOwn(\${$singularName}, '{$currentModelName}'), '403');

		\$url = array('action' => '{$admin}index');
		if (!\$undelete) {
			\$this->{$currentModelName}->del(\$id);
			\$msg = 'The {$singularHumanName} has been deleted.';
			\$this->Message->add(__(\$msg, true), 'ok', true, \$url);
		} else {
			\$this->{$currentModelName}->undelete(\$id);
			\$msg = 'The {$singularHumanName} has been undeleted.';
			\$this->Message->add(__(\$msg, true), 'ok', true, \$url);
		}
	}

PHP;
		return $actions;
	}
/**
 * Assembles and writes a unit test file
 *
 * @param string $className Controller class name
 * @return string Baked test
 * @access private
 */
	function bakeTest($className) {
		$import = $className;
		if ($this->plugin) {
			$import = $this->plugin . '.' . $className;
		}
		$out = "App::import('Controller', '$import');\n\n";
		$out .= "class Test{$className} extends {$className}Controller {\n";
		$out .= "\tvar \$autoRender = false;\n}\n\n";
		$out .= "class {$className}ControllerTest extends CakeTestCase {\n";
		$out .= "\tvar \${$className} = null;\n\n";
		$out .= "\tfunction setUp() {\n\t\t\$this->sut = ClassRegistry::init({$className});\n\t}\n\n";
		$out .= "\tfunction tearDown() {\n\t\tunset(\$this->sut);\n\t}\n}\n";

		$path = CONTROLLER_TESTS;
		if (isset($this->plugin)) {
			$pluginPath = 'plugins' . DS . Inflector::underscore($this->plugin) . DS;
			$path = APP . $pluginPath . 'tests' . DS . 'cases' . DS . 'controllers' . DS;
		}

		$filename = Inflector::underscore($className).'_controller.test.php';
		$this->out("\nBaking unit test for $className...");

		$header = '$Id';
		$content = "<?php \n/* SVN FILE: $header$ */\n/* ". $className ."Controller Test cases generated on: " . date('Y-m-d H:m:s') . " : ". time() . "*/\n{$out}?>";
		return $this->createFile($path . $filename, $content);
	}
}
?>
