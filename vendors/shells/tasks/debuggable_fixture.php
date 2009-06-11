<?php
App::import('Model', 'AppModel');
App::import('Core', 'String');
App::import('Core', 'Security');
/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class DebuggableFixtureTask extends Shell {
	var $path = null;
	var $_tables = array();
	var $_tablesNoJoins = array();
	var $numRecords = 10;
	var $_autoIncrement = 0;
	var $_associators = array();
/**
 * Execution method always used for tasks
 *
 * @access public
 */
	function execute() {
		$this->path = TESTS.'fixtures'.DS;
		$this->__interactive();
	}
/**
 * Handles interactive baking
 *
 * @access private
 */
	function __interactive() {
		$this->hr();
		$this->out(sprintf("Bake Fixtures for All Models\nPath: %s", $this->path));
		$this->hr();
		$this->interactive = true;

		$useTable = null;
		$primaryKey = 'id';
		$validate = array();

		$useDbConfig = 'default';
		$connections = array_keys(get_class_vars('DATABASE_CONFIG'));
		if (count($connections) > 1) {
        	$useDbConfig = $this->in(__('Use Database Config', true) .':', $connections, 'default');
		}

		$this->_generateIds($useDbConfig);
		foreach ($this->_tables as $model => $table) {
			App::import('Model', $model);
			if (!class_exists($model)) {
				$this->out('Model '.$model.' is not present. Please make sure that all models are baked first before fixtures are baked.');
				return false;
			}
		}

		foreach ($this->_tables as $model => $table) {
			$this->bake($model, $table, $useDbConfig);
		}
		return;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _generateIds($useDbConfig = 'default') {
		$tables = $this->tables();
		$db =& ConnectionManager::getDataSource($useDbConfig);

		foreach ($tables as $model => $table) {
			$this->_autoIncrement = 0;
			$fields = $this->_schema($model, $table, $useDbConfig);

			foreach ($fields as $name => $field) {
				if ($name == 'id') {
					for ($i = 0; $i < $this->numRecords; $i++) { 
						$key = ++$this->_autoIncrement;

						if ($field['type'] == 'string' && $field['length'] == 36) {
							$id = String::uuid();
						} else {
							$id = $key;
						}

						$this->_ids[$table][$key] = $id;
					}
				}
			}
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
	function bake($name, $useTable = null, $useDbConfig = 'default') {
		$this->out('');
		$this->hr();
		$this->out(__('The following Fixture is created:', true));
		$this->hr();
		$this->out("Name:       " . $name . "Fixture");
		$this->out("DB Config:  " . $useDbConfig);
		$this->out("DB Table:   " . $useTable);
		$this->hr();

		$this->_reset();
		$out = "<?php\n";
		$out .= "class {$name}Fixture extends CakeTestFixture {\n\n";
		$out .= "\tvar \$name = '{$name}';\n";
		$out .= "\tvar \$records = array(\n";

		$schema = $this->_schema($name, $useTable, $useDbConfig);
		$containsParentReference = false;
		foreach ($schema as $fieldName => $data) {
			if ($fieldName == 'parent_id') {
				$containsParentReference = true;
			}
		}

		if ($containsParentReference) {
			$recLevel = 1;
			$recLevel = $this->in('A self-reference (parent_id) was detected. How many recursion levels do you want to allow for the self-reference? There will be references created UP TO this recursion level.', range(1, 5), $recLevel);
		}

		for ($i = 0; $i < $this->numRecords; $i++) {
			$id = $this->_ids[$useTable][++$this->_autoIncrement];

			$parentId = false;
			if ($containsParentReference) {
				$parentId = $this->_generateParentId($id, $useTable, $schema['parent_id'], $recLevel);
				$this->_parentIds[$id] = $parentId;
			}

			$out .= "\t\tarray(\n";
			foreach ($schema as $fieldName => $data) {
				$value = $this->_createValue($fieldName, $data, $useTable, $id, $parentId, $useDbConfig);
				if ($value !== null) {
					$value = "'{$value}'";
				} else {
					$value = 'null';
				}
				$out .= "\t\t\t'{$fieldName}' => {$value},\n";
			}
			$out .= "\t\t),\n";
		}
		$out .= "\t);\n";
		$out .= "}\n";
		$out .= "?>";
		$filename = $this->path . Inflector::underscore($name) . '_fixture.php';
		return $this->createFile($filename, $out);
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $table 
 * @return void
 * @access public
 */
	function _schema($model, $table, $useDbConfig) {
		$tempModel = new Model(array('name' => $model, 'table' => $table, 'ds' => $useDbConfig));
		return $tempModel->schema();
	}
/**
 * outputs the a list of possible models or controllers from database
 *
 * @param string $useDbConfig Database configuration name
 * @access public
 */
	function tables($useDbConfig = 'default') {
		if (!empty($this->_tables)) {
			return $this->_tables;
		}

		$db =& ConnectionManager::getDataSource($useDbConfig);
		$usePrefix = empty($db->config['prefix']) ? '' : $db->config['prefix'];
		$prefixLength = strlen($usePrefix);

		$tables = array();
		foreach ($db->listSources() as $table) {
			$tableName = substr($table, $prefixLength);
			$modelName = $this->_modelName($tableName);
			$tables[$modelName] = $tableName;
		}
		return $this->_tables = $tables;
	}
/**
 * undocumented function
 *
 * @param string $keyName 
 * @param string $table 
 * @return void
 * @access public
 */
	function _findAssocTableBasedOnForeignKey($keyName, $rootTable, $useDbConfig) {
		$className = false;
		$tables = $this->tables();
		$assocs = array('belongsTo', 'hasOne', 'hasMany', 'hasAndBelongsToMany');

		foreach ($tables as $model => $table) {
			App::import('Model', $model);
			$tempModel = new $model();
			foreach ($assocs as $assoc) {

				if (empty($tempModel->$assoc)) {
					continue;
				}
				
				foreach ($tempModel->$assoc as $data) {
					if ($data['foreignKey'] == $keyName) {
						$className = $data['className'];
					}
				}
			}
		}

		if (!$className) {
			$this->out('Found foreign key that points at a non-existing table: table - '.$rootTable.', foreignkey - '.$keyName);
			exit(1);
		}

		return Inflector::tableize($className);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @param string $table 
 * @param string $schema 
 * @return void
 * @access public
 */
	function _generateParentId($id, $table, $schema, $recLevel) {
		$recLevel--;
		$percentage = 4;
		if ($recLevel != 2) {
			$percentage = 7;
		}
		$doNull = rand(0, 10) < $percentage;
		$nullValue = ($schema['type'] == 'string') ? null : 0;

		if (empty($this->_parentIds) || $doNull) {
			return $nullValue;
		}

		$copy = $this->_ids[Inflector::pluralize($table)];

		while (true) {
			shuffle($copy);
			$result = $copy[0];
			if ($result == $id) {
				continue;
			}

			foreach ($this->_parentIds as $subId => $parentId) {
				if ($parentId == $id && $subId == $result) {
					continue 2;
				}
			}

			$newParentId = $result;
			for ($i = 0; $i < $recLevel; $i++) {
				$oldParentId = $newParentId;
				if (array_key_exists($newParentId, $this->_parentIds)) {
					$newParentId = $this->_parentIds[$newParentId];

					if ($newParentId == $id && $oldParentId == $result) {
						continue 2;
					}
				} else {
					if ($recLevel > 1 && $newParentId != $nullValue) {
						continue 2;
					}
					break;
				}
			}
			break;
		}

		return $result;
	}
/**
 * undocumented function
 *
 * @param string $data 
 * @return void
 * @access public
 */
	function _createValue($name, $data, $table, $id, $parentId, $useDbConfig) {
		if ($name == 'id') {
			return $id;
		}

		if (strrpos($name, '_id') === strlen($name) - 3) {
			$pos = strrpos($name, '_id');
			$assocTable = Inflector::pluralize(substr($name, 0, $pos));

			if ($assocTable == 'parents') {
				return $parentId;
			}

			if ($assocTable == 'foreigns') {
				return ''; // foreign_id currently not supported
			}

			if (!isset($this->_ids[Inflector::pluralize($assocTable)])) {
				$assocTable = $this->_findAssocTableBasedOnForeignKey($name, $table, $useDbConfig);
			}
			$copy = $this->_ids[Inflector::pluralize($assocTable)];

			do {
				shuffle($copy);
				$result = $copy[0];
			} while ($result == $id);

			return $result;
		}

		if (in_array($name, array('created', 'modified', 'updated')) || strrpos($name, '_date') === strlen($name) - 5) {
			$format = 'Y-m-d H:i:s';
			if ($data['type'] == 'date') {
				$format = 'Y/m/d';
			}
			return date($format);
		}

		if ($name == 'expires') {
			$format = 'Y-m-d H:i:s';
			if ($data['type'] == 'date') {
				$format = 'Y/m/d';
			}
			return date($format, strtotime('+10 days'));
		}


		$firstNames = array('Jim', 'Joe', 'Bob', 'Tim', 'Peter');
		$lastNames = array('Smith', 'Ross', 'Johnson', 'Matley', 'Koschuetzki');
		if ($name == 'name' || strpos($name, '_name') === strlen($name) - 5) {
			shuffle($firstNames);
			shuffle($lastNames);
			return $firstNames[0]." ".$lastNames[0];
		}

		if (strpos($name, 'first_name') !== false) {
			shuffle($firstNames);
			return $firstNames[0];
		}

		if (strpos($name, 'last_name') !== false || strpos($name, 'sur_name') !== false) {
			shuffle($lastNames);
			return $lastNames[0];
		}

		if ($name == 'email' || strpos($name, 'email') === strlen($name) - 6) {
			shuffle($firstNames);
			return $firstNames[0]."@example.com";
		}

		if ($name == 'password' || strrpos($name, '_password') === strlen($name) - 9) {
			$pw = 'test';
			require_once LIBS.'security.php';
			return Security::hash(Configure::read('Security.salt').$pw);
		}

		if ($name == 'url' || strrpos($name, '_url') === strlen($name) - 4) {
			return 'http://example.com';
		}

		if ($name == 'integer') {
			$length = $data['length'];
			$max = (int) str_pad('1', $length, '0') - 1;
			echo $max."\n";
			return rand(0, $max);
		}

		if ($data['type'] == 'boolean') {
			return rand(0, 1);
		}

		if ($name == 'text') {
			return 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			';
		}
		
		if ($name == 'ip' || strrpos($name, '_ip') === strlen($name) - 3) {
			return '127.0.0.1';
		}

		return $name."_".$this->_autoIncrement;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _reset() {
		$this->_autoIncrement = 0;
		$this->_parentIds = array();
	}
/**
 * Displays help contents
 *
 * @access public
 */
	function help() {
		$this->hr();
		$this->out("Usage: cake bake fixture <arg1>");
		$this->hr();
		$this->out('Commands:');
		$this->out("\n\fixture\n\t\tbakes fixture in interactive mode.");
		$this->out("\n\fixture <name>\n\t\tbakes fixture file with standard primary key and default db config");
		$this->out("");
		exit();
	}
}
?>