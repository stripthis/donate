<?php
require_once CONSOLE_LIBS.'tasks'.DS.'model.php';
class DebuggableModelTask extends ModelTask {
/**
 * Handles interactive baking
 *
 * @access private
 */
	function __interactive() {
		$this->hr();
		$this->out(sprintf("Bake Model\nPath: %s", $this->path));
		$this->hr();
		$this->interactive = true;

		$useTable = null;
		$primaryKey = 'id';
		$validate = array();
		$associations = array('belongsTo'=> array(), 'hasOne'=> array(), 'hasMany' => array(), 'hasAndBelongsToMany'=> array());

		$useDbConfig = 'default';
		$configs = get_class_vars('DATABASE_CONFIG');

		if (!is_array($configs)) {
			return $this->DbConfig->execute();
		}

		$connections = array_keys($configs);
		if (count($connections) > 1) {
        	$useDbConfig = $this->in(__('Use Database Config', true) .':', $connections, 'default');
		}

		$currentModelName = $this->getName($useDbConfig);
		$db =& ConnectionManager::getDataSource($useDbConfig);
		$useTable = Inflector::tableize($currentModelName);
		$fullTableName = $db->fullTableName($useTable, false);
		$tableIsGood = false;

		if (array_search($useTable, $this->__tables) === false) {
			$this->out('');
			$this->out(sprintf(__("Given your model named '%s', Cake would expect a database table named %s", true), $currentModelName, $fullTableName));
			$tableIsGood = $this->in(__('Do you want to use this table?', true), array('y','n'), 'y');
		}

		if (low($tableIsGood) == 'n' || low($tableIsGood) == 'no') {
			$useTable = $this->in(__('What is the name of the table (enter "null" to use NO table)?', true));
		}

		while ($tableIsGood == false && low($useTable) != 'null') {
			if (is_array($this->__tables) && !in_array($useTable, $this->__tables)) {
				$fullTableName = $db->fullTableName($useTable, false);
				$this->out($fullTableName . ' does not exist.');
				$useTable = $this->in(__('What is the name of the table (enter "null" to use NO table)?', true));
				$tableIsGood = false;
			} else {
				$tableIsGood = true;
			}
		}

		$wannaDoValidation = $this->in(__('Would you like to supply validation criteria for the fields in your model?', true), array('y','n'), 'y');

		if (in_array($useTable, $this->__tables)) {
			App::import('Model');
			$tempModel = new Model(array('name' => $currentModelName, 'table' => $useTable, 'ds' => $useDbConfig));

			$fields = $tempModel->schema();
			if (!array_key_exists('id', $fields)) {
				foreach ($fields as $name => $field) {
					if (isset($field['key']) && $field['key'] == 'primary') {
						break;
					}
				}
				$primaryKey = $this->in(__('What is the primaryKey?', true), null, $name);
			}
		}

		if (array_search($useTable, $this->__tables) !== false && (low($wannaDoValidation) == 'y' || low($wannaDoValidation) == 'yes')) {
			$validate = $this->doValidation($tempModel);
		}

		$wannaDoAssoc = $this->in(__('Would you like to define model associations (hasMany, hasOne, belongsTo, etc.)?', true), array('y','n'), 'y');
		if ((low($wannaDoAssoc) == 'y' || low($wannaDoAssoc) == 'yes')) {
			$associations = $this->doAssociations($tempModel);
		}

		$this->out('');
		$this->hr();
		$this->out(__('The following Model will be created:', true));
		$this->hr();
		$this->out("Name:       " . $currentModelName);

		if ($useDbConfig !== 'default') {
			$this->out("DB Config:  " . $useDbConfig);
		}
		if ($fullTableName !== Inflector::tableize($currentModelName)) {
			$this->out("DB Table:   " . $fullTableName);
		}
		if ($primaryKey != 'id') {
			$this->out("Primary Key: " . $primaryKey);
		}
		if (!empty($validate)) {
			$this->out("Validation: " . print_r($validate, true));
		}
		if (!empty($associations)) {
			$this->out("Associations:");

			if (!empty($associations['belongsTo'])) {
				for ($i = 0; $i < count($associations['belongsTo']); $i++) {
					$this->out("			$currentModelName belongsTo {$associations['belongsTo'][$i]['alias']}");
				}
			}

			if (!empty($associations['hasOne'])) {
				for ($i = 0; $i < count($associations['hasOne']); $i++) {
					$this->out("			$currentModelName hasOne	{$associations['hasOne'][$i]['alias']}");
				}
			}

			if (!empty($associations['hasMany'])) {
				for ($i = 0; $i < count($associations['hasMany']); $i++) {
					$this->out("			$currentModelName hasMany	{$associations['hasMany'][$i]['alias']}");
				}
			}

			if (!empty($associations['hasAndBelongsToMany'])) {
				for ($i = 0; $i < count($associations['hasAndBelongsToMany']); $i++) {
					$this->out("			$currentModelName hasAndBelongsToMany {$associations['hasAndBelongsToMany'][$i]['alias']}");
				}
			}
		}
		$this->hr();
		$looksGood = $this->in(__('Look okay?', true), array('y','n'), 'y');

		if (low($looksGood) == 'y' || low($looksGood) == 'yes') {
			if ($this->bake($currentModelName, $associations, $validate, $primaryKey, $useTable, $useDbConfig)) {
				if ($this->_checkUnitTest()) {
					$this->bakeTest($currentModelName, $useTable, $associations);
				}
			}
		} else {
			return false;
		}
	}
/**
 * Assembles and writes a Model file.
 *
 * @param mixed $name Model name or object
 * @param mixed $associations if array and $name is not an object assume Model associations array otherwise boolean interactive
 * @param array $validate Validation rules
 * @param string $primaryKey Primary key to use
 * @param string $useTable Table to use
 * @param string $useDbConfig Database configuration setting to use
 * @access private
 */
	function bake($name, $associations = array(),  $validate = array(), $primaryKey = 'id', $useTable = null, $useDbConfig = 'default') {
		if (is_object($name)) {
			if (!is_array($associations)) {
				$associations = $this->doAssociations($name, $associations);
				$validate = $this->doValidation($name, $associations);
			}
			$primaryKey = $name->primaryKey;
			$useTable = $name->table;
			$this->useDbConfig = $name->useDbConfig;
			$name = $name->name;
		}

		$out = "<?php\n";
		$out .= "class {$name} extends AppModel {\n\n";
		$out .= "\tvar \$name = '{$name}';\n";

		if (isset($this->useDbConfig) && $this->useDbConfig !== 'default') {
			$out .= "\tvar \$useDbConfig = '$this->useDbConfig';\n";
		}

		if (($useTable && $useTable !== Inflector::tableize($name)) || $useTable == false) {
			$table = "'$useTable'";
			if (!$useTable || $useTable == 'null' || $useTable == 'false') {
				$table = 'false';
			}
			$out .= "\tvar \$useTable = $table;\n";
		}

		if ($primaryKey !== 'id') {
			$out .= "\tvar \$primaryKey = '$primaryKey';\n";
		}

		$validateCount = count($validate);
		if (is_array($validate) && $validateCount > 0) {
			$out .= "\tvar \$validate = array(\n";
			$keys = array_keys($validate);
			for ($i = 0; $i < $validateCount; $i++) {
				$out .= "\t\t'" . $keys[$i] . "' => array('" . $validate[$keys[$i]] . "')";
				if ($i + 1 < $validateCount) {
					$out .= ",";
				}
				$out .= "\n";
			}
			$out .= "\t);\n";
		}
		$out .= "\n";

		if (!empty($associations)) {
			if (!empty($associations['belongsTo']) || !empty($associations['$hasOne']) || !empty($associations['hasMany']) || !empty($associations['hasAndBelongsToMany'])) {
			}

			if (!empty($associations['belongsTo'])) {
				$out .= "\tvar \$belongsTo = array(\n";
				$belongsToCount = count($associations['belongsTo']);

				for ($i = 0; $i < $belongsToCount; $i++) {
					$out .= "\t\t'{$associations['belongsTo'][$i]['alias']}'";
					if ($i + 1 < $belongsToCount) {
						$out .= ",";
					}
					$out .= "\n";
				}
				$out .= "\t);\n\n";
			}

			if (!empty($associations['hasOne'])) {
				$out .= "\tvar \$hasOne = array(\n";
				$hasOneCount = count($associations['hasOne']);

				for ($i = 0; $i < $hasOneCount; $i++) {
					$out .= "\t\t'{$associations['hasOne'][$i]['alias']}'";
					if ($i + 1 < $hasOneCount) {
						$out .= ",";
					}
					$out .= "\n";

				}
				$out .= "\t);\n\n";
			}

			if (!empty($associations['hasMany'])) {
				$out .= "\tvar \$hasMany = array(\n";
				$hasManyCount = count($associations['hasMany']);

				for ($i = 0; $i < $hasManyCount; $i++) {
					$out .= "\t\t'{$associations['hasMany'][$i]['alias']}'";
					if ($i + 1 < $hasManyCount) {
						$out .= ",";
					}
					$out .= "\n";
				}
				$out .= "\t);\n\n";
			}

			if (!empty($associations['hasAndBelongsToMany'])) {
				$out .= "\tvar \$hasAndBelongsToMany = array(\n";
				$hasAndBelongsToManyCount = count($associations['hasAndBelongsToMany']);

				for ($i = 0; $i < $hasAndBelongsToManyCount; $i++) {
					$out .= "\t\t'{$associations['hasAndBelongsToMany'][$i]['alias']}'";
					if ($i + 1 < $hasAndBelongsToManyCount) {
						$out .= ",";
					}
					$out .= "\n";
				}
				$out .= "\t);\n\n";
			}
		}
		$out .= "}\n";
		$out .= "?>";
		$filename = $this->path . Inflector::underscore($name) . '.php';
		$this->out("\nBaking model class for $name...");
		return $this->createFile($filename, $out);
	}
/**
 * Assembles and writes a unit test file
 *
 * @param string $className Model class name
 * @access private
 */
	function bakeTest($className, $useTable = null, $associations = array()) {
		$import = $className;
		if (isset($this->plugin)) {
			$import = $this->plugin . '.' . $className;
		}

		$out = "<?php\nApp::import('Model', '$import');\n\n";
		$out .= "class Test{$className} extends {$className} {\n";
		$out .= "\tvar \$cacheSources = false;\n";
		$out .= "\tvar \$this->useDbConfig  = 'test_suite';\n}\n\n";
		$out .= "class {$className}TestCase extends CakeTestCase {\n";
		$out .= "\tvar \${$className} = null;\n";
		$out .= "\tvar \$fixtures = array($fixture);\n\n";
		$out .= "\tfunction setUp() {\n\t\t\$this->{$className} = new Test{$className}();\n\t}\n\n";
		$out .= "\tfunction test{$className}Instance() {\n";
		$out .= "\t\t\$this->assertTrue(is_a(\$this->{$className}, '{$className}'));\n\t}\n\n";
		$out .= "\tfunction test{$className}Find() {\n";
		$out .= "\t\t\$results = \$recursive = -1;\n";
		$out .= "\t\t\$results = \$this->{$className}->find('first', compact('recursive'));\n\t\t\$this->assertTrue(!empty(\$results));\n\n";
		$out .= "\t\t\$expected = array('$className' => array());\n";
		$out .= "\t\t\$this->assertEqual(\$results, \$expected);\n\t}\n}\n?>";

		$path = MODEL_TESTS;
		if (isset($this->plugin)) {
			$pluginPath = 'plugins' . DS . Inflector::underscore($this->plugin) . DS;
			$path = APP . $pluginPath . 'tests' . DS . 'cases' . DS . 'models' . DS;
		}

		$filename = Inflector::underscore($className).'.test.php';
		$this->out("\nBaking unit test for $className...");

		return $this->createFile($path . $filename, $out);
	}
}
?>