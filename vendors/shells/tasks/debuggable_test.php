<?php
require_once CONSOLE_LIBS.'tasks'.DS.'test.php';
class DebuggableTestTask extends TestTask {
/**
 * Execution method always used for tasks
 *
 * @access public
 */
	function execute() {
		if (empty($this->args)) {
			$this->__interactive();
		}

		if (count($this->args) == 1) {
			$this->__interactive($this->args[0]);
		}

		if (count($this->args) > 1) {
			$class = Inflector::underscore($this->args[0]);
			if ($this->bake($class, $this->args[1])) {
				$this->out('done');
			}
		}
	}
/**
 * Handles interactive baking
 *
 * @access private
 */
	function __interactive($class = null) {
		$this->hr();
		$this->out(sprintf("Bake Tests\nPath: %s", $this->path));
		$this->hr();

		$key = null;	
		$options = array('Behavior', 'Helper', 'Component', 'Model', 'Controller');

		if ($class !== null) {
			$class = Inflector::camelize($class);
			if (in_array($class, $options)) {
				$key = array_search($class);
			}
		}

		while ($class == null) {
			$this->hr();
			$this->out("Select a class:");
			$this->hr();

			$keys = array();
			foreach ($options as $key => $option) {
				$this->out(++$key . '. ' . $option);
				$keys[] = $key;
			}
			$keys[] = 'q';

			$key = $this->in(__("Enter the class to test or (q)uit", true), $keys, 'q');

			if ($key != 'q') {
				if (isset($options[--$key])) {
					$class = $options[$key];
				}
				if ($class) {
					$this->path = TESTS . 'cases' . DS . Inflector::tableize($class) . DS;

					$name = $this->in(__("Enter the name for the test, (a)ll' or (q)uit", true), null, 'q');

					switch ($name) {
						case 'q':
							exit();
							break;
						case 'a':
							$path = APP.low(Inflector::pluralize($class));
							if (in_array($class, array('Behavior', 'Component', 'Helper'))) {
								switch ($class) {
									case 'Behavior':
										$path = APP.'models'.DS.low(Inflector::pluralize($class));
										break;
									case 'Component':
										$path = APP.'controllers'.DS.low(Inflector::pluralize($class));
										break;
									default:
										$path = APP.'views'.DS.low(Inflector::pluralize($class));
										break;
								}
							}

							$folder = new Folder($path);

							$contents = $folder->read();
							foreach ($contents[1] as $file) {
								if ($file == 'empty') {
									continue;
								}
								$contents = file_get_contents($path.DS.$file);
								$modelName = Inflector::camelize(r('.php', '', $file));
								preg_match_all('/function\s*([^\(\n]+)\(/', $contents, $matches);

								$cases = array();
								foreach ($matches[1] as $funcName) {
									$cases[] = Inflector::camelize($funcName);
								}
								$this->bake($class, $modelName, $cases);
							}
							break;
						default:
							$case = null;
							while ($case !== 'q') {
								$case = $this->in(__("Enter a test case or (q)uit", true), null, 'q');
								if ($case !== 'q') {
									$cases[] = $case;
								}
							}
							if ($this->bake($class, $name, $cases)) {
								$this->out(__("Test baked\n", true));
								$type = null;
							}
							$class = null;
							break;
					}
				}
			} else {
				exit();
			}
		}
	}
/**
 * Writes File
 *
 * @access public
 */	
	function bake($class, $name = null, $cases = array()) {
		if (!$name) {
			return false;
		}
		
		if (!is_array($cases)) {
			$cases = array($cases);
		}

		$name = Inflector::camelize($name);
		$import = $name;
		if (isset($this->plugin)) {
			$import = $this->plugin . '.' . $name;
		}
		$extras = $this->__extras($class);
		if ($class == 'Model') {
			$class = null;
		}

		if (strpos($name, $class) === false) {
			$name .= $class;
		}

		$out = '';
		foreach (array('Controller', 'Behavior', 'Component', 'Helper') as $type) {
			if (strpos($name, $type) !== false) {
				$cName = r($type, '', $name);
				$out .= "App::import('{$type}', '{$cName}');\n";
			}
		}

		$out .= "class {$name}Test extends CakeTestCase {\n";
		$out .= "\tfunction setUp() {\n\t\t\$this->{$name} = ClassRegistry::init('{$name}');\n\t}\n";
		$out .= "\n\tfunction test{$name}Instance() {\n";
		$out .= "\t\t\$this->assertTrue(is_a(\$this->{$name}, '{$name}'));\n\t}\n";
		foreach ($cases as $case) {
			$case = Inflector::classify($case);
			$out .= "\n\tfunction test{$case}() {\n\n\t}\n";
		}
		$out .= "}\n";
		
		$this->out("Baking unit test for $name...");
		$this->out($out);
		$ok = $this->in(__('Is this correct?'), array('y', 'n'), 'y');
		if ($ok == 'n') {
			return false;
		}

		$content = "<?php\n{$out}?>";
		return $this->createFile($this->path . Inflector::underscore($name) . '.test.php', $content);
	}
}
?>