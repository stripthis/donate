<?php
App::import('Core', 'Controller');
require_once CONSOLE_LIBS.'tasks'.DS.'view.php';
class DebuggableViewTask extends ViewTask {
/**
 * Tasks to be loaded by this Task
 *
 * @var array
 * @access public
 */
	var $tasks = array(
		'DebuggableProject',
		'DebuggableController',
	);
/**
 * Handles interactive baking
 *
 * @access private
 */
	function __interactive() {
		$this->hr();
		$this->out(sprintf("Bake View\nPath: %s", $this->path));
		$this->hr();
		$wannaDoAdmin = 'n';
		$wannaDoScaffold = 'y';
		$this->interactive = false;

		$this->loadTasks();
		$this->controllerName = $this->DebuggableController->getName();

		$this->controllerPath = low(Inflector::underscore($this->controllerName));

		$interactive = $this->in("Would you like bake to build your views interactively?\nWarning: Choosing no will overwrite {$this->controllerName} views if it exist.", array('y','n'), 'y');

		if (low($interactive) == 'y' || low($interactive) == 'yes') {
			$this->interactive = true;
			$wannaDoScaffold = $this->in("Would you like to create some scaffolded views (index, add, view, edit) for this controller?\nNOTE: Before doing so, you'll need to create your controller and model classes (including associated models).", array('y','n'), 'n');
		}

		if (low($wannaDoScaffold) == 'y' || low($wannaDoScaffold) == 'yes') {
			$wannaDoAdmin = $this->in("Would you like to create the views for admin routing?", array('y','n'), 'y');
		}
		$admin = false;

		if ((low($wannaDoAdmin) == 'y' || low($wannaDoAdmin) == 'yes')) {
			$admin = $this->getAdmin();
		}

		if (low($wannaDoScaffold) == 'y' || low($wannaDoScaffold) == 'yes') {
			$actions = $this->scaffoldActions;
			if ($admin) {
				foreach ($actions as $action) {
					$actions[] = $admin . $action;
				}
			}
			$vars = $this->__loadController();
			if ($vars) {
				foreach ($actions as $action) {
					$content = $this->getContent($action, $vars);
					$this->bake($action, $content);
				}
			}
			$this->hr();
			$this->out('');
			$this->out('View Scaffolding Complete.'."\n");
		} else {
			$action = '';
			while ($action == '') {
				$action = $this->in('Action Name? (use camelCased function name)');
				if ($action == '') {
					$this->out('The action name you supplied was empty. Please try again.');
				}
			}
			$this->out('');
			$this->hr();
			$this->out('The following view will be created:');
			$this->hr();
			$this->out("Controller Name: {$this->controllerName}");
			$this->out("Action Name:	 {$action}");
			$this->out("Path:			 ".$this->params['app'] . DS . $this->controllerPath . DS . Inflector::underscore($action) . ".ctp");
			$this->hr();
			$looksGood = $this->in('Look okay?', array('y','n'), 'y');
			if (low($looksGood) == 'y' || low($looksGood) == 'yes') {
				$this->bake($action);
				exit();
			} else {
				$this->out('Bake Aborted.');
				exit();
			}
		}
	}
/**
 * Builds content from template and variables
 *
 * @param string $template file to use
 * @param array $vars passed for use in templates
 * @return string content from template
 * @access public
 */
	function getContent($template = null, $vars = null) {
		if (!$template) {
			$template = $this->template;
		}
		$action = $template;

		$adminRoute = Configure::read('Routing.admin');
		$admin = '';
		if (!empty($adminRoute) && strpos($template, $adminRoute) !== false) {
			$admin = $adminRoute.'_';
			$template = str_replace($adminRoute.'_', '', $template);
		}
		if (in_array($template, array('add', 'edit'))) {
			$action = $template;
			$template = 'form';
		}
		$loaded = false;
		$templatePath = VENDORS.'shells'.DS.'templates'.DS.'views'.DS.Inflector::underscore($template).'.ctp';

		if (!file_exists($templatePath) || !is_file($templatePath)) {
			$this->err(sprintf(__('Template for %s could not be found', true), $template));
			return false;
		}

		if (!$vars) {
			$vars = $this->__loadController();
		}
		$vars = am($vars, array('admin' => $admin));

		extract($vars);
		ob_start();
		ob_implicit_flush(0);
		include($templatePath);
		$content = ob_get_clean();
		return $content;
	}
/**
 * Loads Controller and sets variables for the template
 * Available template variables
 *	'modelClass', 'primaryKey', 'displayField', 'singularVar', 'pluralVar',
 *	'singularHumanName', 'pluralHumanName', 'fields', 'foreignKeys',
 *	'belongsTo', 'hasOne', 'hasMany', 'hasAndBelongsToMany'
 *
 * @return array Returns an variables to be made available to a view template
 * @access private
 */
	function __loadController() {
		if (!$this->controllerName) {
			$this->err(__('Controller not found', true));
		}

		$import = $this->controllerName;
		if ($this->plugin) {
			$import = $this->plugin . '.' . $this->controllerName;
		}

		if (!App::import('Controller', $import)) {
			$file = $this->controllerPath . '_controller.php';
			$this->err(sprintf(__("The file '%s' could not be found.\nIn order to bake a view, you'll need to first create the controller.", true), $file));
			exit();
		}
		$controllerClassName = $this->controllerName . 'Controller';
		$controllerObj = & new $controllerClassName();
		$controllerObj->constructClasses();
		$modelClass = $controllerObj->modelClass;
		$modelObj =& ClassRegistry::init($modelClass);

		if ($modelObj) {
			$primaryKey = $modelObj->primaryKey;
			$displayField = $modelObj->displayField;
			$singularVar = Inflector::variable($modelClass);
			$pluralVar = Inflector::variable($this->controllerName);
			$singularHumanName = Inflector::humanize($modelClass);
			$singularName = Inflector::singularize($modelClass);
			$pluralHumanName = Inflector::humanize($this->controllerName);
			$schema = $modelObj->schema();
			$fields = array_keys($schema);
			$modelObj->__createLinks();
			$associations = $this->__associations($modelObj);
		} else {
			$primaryKey = null;
			$displayField = null;
			$singularVar = Inflector::variable(Inflector::singularize($this->controllerName));
			$pluralVar = Inflector::variable($this->controllerName);
			$singularName = $this->controllerName;
			$singularHumanName = Inflector::humanize(Inflector::singularize($this->controllerName));
			$pluralHumanName = Inflector::humanize($this->controllerName);
			$fields = array();
			$schema = array();
			$associations = array();
		}

		return compact('modelClass', 'schema', 'primaryKey', 'displayField', 'singularVar', 'pluralVar', 'singularName', 
				'singularHumanName', 'pluralHumanName', 'fields', 'associations');
	}
}
?>