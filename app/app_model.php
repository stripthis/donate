<?php
class AppModel extends Model {
	var $actsAs = array('Lookupable', 'Containable');
/**
 * Never fetch any recursive data from associated models
 * Use containable for any assocs
 *
 * @var integer
 */
	public $recursive = -1;
	var $__definedAssociations = array();
	var $__loadAssociations = array('Aro', 'Aco', 'Permission');
/**
 * undocumented function
 *
 * @param string $id 
 * @param string $table 
 * @param string $ds 
 * @return void
 * @access public
 */
	function __construct($id = false, $table = null, $ds = null) {
		if (!in_array(get_class($this), $this->__loadAssociations)) {
			foreach ($this->__associations as $association) {
				if ($association == 'belongsTo') {
					continue;
				}
				foreach ($this->{$association} as $key => $value) {
					$assocName = $key;
	
					if (is_numeric($key)) {
						$assocName = $value;
						$value = array();
					}
	
					$value['type'] = $association;
					$this->__definedAssociations[$assocName] = $value;
					if (!empty($value['with'])) {
						$this->__definedAssociations[$value['with']] = array('type' => 'hasMany');
					}
				}
	
				$this->{$association} = array();
			}
		}
	
		parent::__construct($id, $table, $ds);
	}
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function __isset($name) {
		return $this->__connect($name);
	}
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function __get($name) {
		return $this->__connect($name);
	}
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function __connect($name) {
		if (empty($this->__definedAssociations[$name])) {
			return false;
		}

		$this->bind($name, $this->__definedAssociations[$name]);
		return $this->{$name};
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function onError() {
		$call = array('type' => 'query');
		$stack = debug_backtrace();
		foreach ($stack as &$call) {
			if (@preg_match('/^(save|find|delete).*/', $call['function'], $match) && @$call['class'] == 'Model') {
				$call = array(
					'type' => $match[1]
					, 'function' => $call['function']
					, 'line' => $call['line']
					, 'file' => $call['file']
				);
				break;
			}
		}
		throw new AppException($call);
	}
/**
 * Executed by the paginator to get the count. Overriden to allow
 * forcing a count (through var $forcePaginateCount)
 *
 * @param array $conditions Conditions to use
 * @param int $recursive Recursivity level
 * @return int Count
 * @access public
 */
	function paginateCount($conditions, $recursive) {
		if (isset($this->forcePaginateCount)) {
			$count = $this->forcePaginateCount;
			unset($this->forcePaginateCount);
		} else {
			$count = $this->find('count', compact('conditions', 'recursive'));
		}
		return $count;
	}
/**
 * undocumented function
 *
 * @param string $find
 * @return void
 * @access public
 */
	function batchFind($find) {
		$data = array();
		foreach ($find as $type => $query) {
			if (is_numeric($type)) {
				$type = $query;
				$query = array();
			}
			$data[$type] = $this->find($type, $query);
		}
		return $data;
	}
/**
 * Returns if the parameter object belongs to the currently logged in user
 *
 * @param array $obj
 * @param string $model
 * @return boolean true if the $obj array contains a user_id key that is equal to User::get('id'), false if not
 * @access public
 */
	static function isOwn($obj, $model) {
		Assert::isArray($obj);
		if (isset($obj[$model]['user_id'])) {
			$userId = $obj[$model]['user_id'];
		} else {
			if (isset($obj['user_id'])) {
				$userId = $obj['user_id'];
			} else {
				$userId = User::get('id');
			}
		}
		if (!Common::isUuid($userId)) {
			return false;
		}
		return $userId == User::get('id');
	}
/**
 * undocumented function
 *
 * @param string $model
 * @param string $id
 * @param string $query
 * @return void
 * @access public
 */
	static function normalize($model, $id, $inverse = false) {
		$record = $id;
		if (!$inverse) {
			if (!isset($record[$model])) {
				$record = array($model => $record);
			}
		} else {
			foreach ($id[$model] as $field => $value) {
				$record[$field] = $value;
			}
		}
		return $record;
	}
/**
 * undocumented function
 *
 * @param string $model
 * @param string $id
 * @return void
 * @access public
 */
	static function url($model, $id, $options = array()) {
		if (!isset($options['admin'])) {
			$options['admin'] = false;
		}
		$record = AppModel::normalize($model, $id);
		if (!$record) {
			return false;
		}
		$controller = Inflector::underscore(Inflector::pluralize($model));

		return am(array(
			'controller' => $controller,
			'action' => 'view',
			$record[$model]['id'],
			'admin' => $options['admin']
		), $options);
	}
/**
 * Checks if the value defined is unique for the given data model.
 * The check for uniqueness is case-insensitive.  If
 * {@link $params}['conditions'] is given, this is used as a constraint.
 * If {@link $params}['scope'] is given, the value is only checked against
 * records that match the value of the column/field defined by
 * {@link $params}['scope'].
 *
 * @param array $value Array in the form of $field => $value.
 * @return bool True if value is unique; false otherwise.
 */
	function validateUnique($value, $params) {
		return $this->isUnique(array($params['field'] => $this->__validateValue($value)));
	}
/**
 * Checks if the value defined corresponds with
 * it's confirmation value, which is defined by the field specified in
 * {@link $params}['confirm'].
 *
 * @param array $value Array in the form of $field => $value.
 * @return bool True if value corresponds to its confirmation value; false otherwise.
 */
	function validateConfirmed($value, $params) {
		$value = $this->__validateValue($value);
		if (!isset($this->data[$this->alias][$params['confirm']])) {
			return false;
		}

		$confirmationValue = $this->data[$this->alias][$params['confirm']];
		return (strcmp($value, $confirmationValue) == 0);
	}
/**
 * Checks that a value is over the specified minimum
 *
 * @param string $check Value to check
 * @param integer $min Minimum value in range (inclusive)
 * @return boolean Success
 * @access public
 */
	function validateMinimum($value, $min) {
		$value = $this->__validateValue($value);
		return ($value >= $min);
	}
/**
 * Checks that a value is below the specified maximum
 *
 * @param string $check Value to check
 * @param integer $max Maximum value in range (inclusive)
 * @return boolean Success
 * @access public
 */
	function validateMaximum($value, $max) {
		$value = $this->__validateValue($value);
		return ($value <= $max);
	}
/**
 * Extract the value to validate.
 *
 * @param mixed $value If array, first element value is value, otherwise $value
 * @return string Value to validate
 * @access private
 *
 * @param string $value
 * @return void
 * @access public
 */
	function __validateValue($value) {
		if (is_array($value)) {
			$value = array_pop(array_reverse($value));
		}
		return $value;
	}
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateCountry($check) {
		$country = ClassRegistry::init('Country')->lookup(
			array('id' => current($check)), 'id', false
		);
		return !empty($country);
	}
/**
 * Validate State - check if it exist based on the id
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateState($check) {
		$state = ClassRegistry::init('State')->lookup(
			array('id' => current($check)), 'id', false
		);
		return !empty($state);
	}
/**
 * Validate Office
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateOffice($check) {
		$office = ClassRegistry::init('Office')->lookup(
			array('id' => current($check)), 'id', false
		);
		return !empty($office);
	}
/**
 * undocumented function
 *
 * @param string $models 
 * @param string $data 
 * @return void
 * @access public
 */
	function bulkValidate($models, $data, $resetRequired = false) {
		$validates = true;
		foreach ($models as $model) {
			if (!isset($this->data[$model])) {
				continue;
			}

			$modelObj = ClassRegistry::init($model);

			foreach ($modelObj->validate as $field => $rules) {
				foreach ($rules as $name => $rule) {
					if ($resetRequired) {
						if (isset($rule['is_required'])) {
							$modelObj->validate[$field][$name]['required'] = true;
						}
					} else {
						if (isset($rule['required'])) {
							$modelObj->validate[$field][$name]['is_required'] = true;
							unset($modelObj->validate[$field][$name]['required']);
						}
					}
				}
			}

			$modelObj->set($data[$model]);
			$validates = $modelObj->validates() && $validates;
		}
		return $validates;
	}
/**
 * undocumented function
 *
 * @param string $models 
 * @return void
 * @access public
 */
	function resetRequired($models) {
		$validates = true;
		foreach ($models as $model) {
			$modelObj = ClassRegistry::init($model);

			foreach ($modelObj->validate as $field => $rules) {
				foreach ($rules as $name => $rule) {
					if (isset($rule['required'])) {
						$modelObj->validate[$field][$name]['is_required'] = true;
						$modelObj->validate[$field][$name]['required'];
					}
				}
			}
		}
	}
/**
 * undocumented function
 *
 * @param string $conditions
 * @param string $params 
 * @param string $model 
 * @param string $field 
 * @return void
 * @access public
 */
	function dateRange($conditions, &$params, $field) {
		if (!empty($params['start_date_year'])) {
			if (empty($params['start_date_month'])) {
				$params['start_date_month'] = '01';
			}
			if (empty($params['start_date_day'])) {
				$params['start_date_day'] = '01';
			}
			$startDate = $params['start_date_year'] . '-' . $params['start_date_month'] . '-' . $params['start_date_day'];
			$conditions[] = "DATE_FORMAT(" . $this->alias . "." . $field. ", '%Y-%m-%d') >= '" . $startDate . "'";
		}

		if (!empty($params['end_date_year'])) {
			if (empty($params['end_date_month'])) {
				$params['end_date_month'] = '01';
			}
			if (empty($params['end_date_day'])) {
				$params['end_date_day'] = '01';
			}
			$endDate = $params['end_date_year'] . '-' . $params['end_date_month'] . '-' . $params['end_date_day'];
			$conditions[] = "DATE_FORMAT(" . $this->alias . "." . $field. ", '%Y-%m-%d') <= '" . $endDate . "'";
		}

		return $conditions;
	}
}
?>