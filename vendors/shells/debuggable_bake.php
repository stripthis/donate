<?php
require_once CONSOLE_LIBS.'bake.php';
class DebuggableBakeShell extends BakeShell {
/**
 * Contains tasks to load and instantiate
 *
 * @var array
 * @access public
 */
	var $tasks = array(
		'DbConfig',
		'DebuggableProject',
		'DebuggableModel',
		'DebuggableController',
		'DebuggableView',
		'DebuggablePlugin',
		'DebuggableTest',
		'DebuggableFixture'
	);
/**
 * Override main() to handle action
 *
 * @access public
 */
	function main() {
		$this->loadTasks();

		if (!is_dir(CONFIGS)) {
			$this->Project->execute();
		}

		if (!config('database')) {
			$this->out(__("Your database configuration was not found. Take a moment to create one.", true));
			$this->args = null;
			return $this->DbConfig->execute();
		}
		$this->out('Interactive Bake Shell');
		$this->hr();
		$this->out('[D]atabase Configuration');
		$this->out('[M]odel');
		$this->out('[V]iew');
		$this->out('[C]ontroller');
		$this->out('[P]roject');
		$this->out('[F]ixture');
		$this->out('[T]est');
		$this->out('[Q]uit');

		$classToBake = strtoupper($this->in(__('What would you like to Bake?', true), array('D', 'M', 'V', 'C', 'P', 'Q', 'F', 'T')));
		$obj = null;
		$map = array(
			'D' => $this->DbConfig,
			'M' => $this->DebuggableModel,
			'V' => $this->DebuggableView,
			'C' => $this->DebuggableController,
			'P' => $this->DebuggableProject,
			'F' => $this->DebuggableFixture,
			'T' => $this->DebuggableTest,
		);

		if (array_key_exists($classToBake, $map)) {
			$obj = $map[$classToBake];
			$obj->execute();
			$this->hr();
			return $this->main();
		}

		if ($classToBake != 'Q') {
			$this->out(__('You have made an invalid selection. Please choose a type of class to Bake by entering D, M, V, or C.', true));
			$this->hr();
			return $this->main();
		}
		exit(0);
	}
/**
 * Quickly bake the MVC
 *
 * @access public
 */
	function all() {
		$this->hr();
		$this->out('Bake All');
		$this->hr();

		$ds = 'default';
		if (isset($this->params['connection'])) {
			$ds = $this->params['connection'];
		}

		if (empty($this->args)) {
			$name = $this->Model->getName($ds);
		}

		if (!empty($this->args[0])) {
			$name = $this->args[0];
			$this->Model->listAll($ds, false);
		}

		$modelExists = false;
		$model = $this->_modelName($name);
		if (App::import('Model', $model)) {
			$object = new $model();
			$modelExists = true;
		} else {
			App::import('Model');
			$object = new Model(array('name' => $name, 'ds' => $ds));
		}

		$modelBaked = $this->DebuggableModel->bake($object, false);

		if ($modelBaked && $modelExists === false) {
			$this->out(sprintf(__('%s Model was baked.', true), $model));
			if ($this->_checkUnitTest()) {
				$this->Model->bakeTest($model);
			}
			$modelExists = true;
		}

		if ($modelExists === true) {
			$controller = $this->_controllerName($name);
			if ($this->Controller->bake($controller, $this->Controller->bakeActions($controller))) {
				$this->out(sprintf(__('%s Controller was baked.', true), $name));
				if ($this->_checkUnitTest()) {
					$this->DebuggableController->bakeTest($controller);
				}
			}
			if (App::import('Controller', $controller)) {
				$this->DebuggableView->args = array($controller);
				$this->DebuggableView->execute();
			}
			$this->out(__('Bake All complete'));
		} else {
			$this->err(__('Bake All could not continue without a valid model', true));
		}

		if (empty($this->args)) {
			$this->all();
		}
		exit();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function tests() {
		$this->loadTasks();

		$ds = 'default';
		$this->hr();
		$this->out('Bake Unit Tests');
		$this->hr();

		if (isset($this->params['connection'])) {
			$ds = $this->params['connection'];
		}

		if (empty($this->args)) {
			$name = $this->DebuggableModel->getName($ds);
		}

		if (!empty($this->args[0])) {
			$name = $this->args[0];
			$this->Model->listAll($ds, false);
		}

		$modelExists = false;
		$model = $this->_modelName($name);
		if (App::import('Model', $model)) {
			$object = new $model();
			$modelExists = true;
		} else {
			$this->out(__('Model doesn\'t exist. Please create it first.'));
		}

		if ($modelExists === true) {
			if ($this->_checkUnitTest()) {
				$this->DebuggableModel->bakeTest($model);
				$this->out(__('Baked model unit test.'));
			}
			$controller = $this->_controllerName($name);
			if (App::import('Controller', $controller)) {
				if ($this->_checkUnitTest()) {
					$this->DebuggableController->bakeTest($controller);
					$this->out(__('Baked controller unit test.'));
				}
			}
		} else {
			$this->err(__('Bake All could not continue without a valid model', true));
		}

		if (empty($this->args)) {
			$this->tests();
		}
		exit();
	}
}
?>