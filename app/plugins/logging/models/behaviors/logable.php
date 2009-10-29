<?php
/**
 * Logs saves and deletes of any model
 * 
 * Requires the following to work as intended :
 * 
 * - "Log" model ( empty but for a order variable [created DESC]
 * - "logs" table with these fields required :
 *     - id			[int]			: 
 *     - title 		[string] 		: automagically filled with the display field of the model that was modified.
 * 	   - created	[date/datetime] : filled by cake in normal way
 * 
 * - actsAs = array("Logable"); on models that should be logged
 * 
 * Optional extra table fields for the "logs" table :
 * 
 * - "description" 	[string] : Fill with a descriptive text of what, who and to which model/row :  
 * 								"Contact "John Smith"(34) added by User "Administrator"(1).
 * 
 * or if u want more detail, add any combination of the following :
 * 
 * - "model"    	[string] : automagically filled with the class name of the model that generated the activity.
 * - "model_id" 	[int]	 : automagically filled with the primary key of the model that was modified.
 * - "action"   	[string] : automagically filled with what action is made (add/edit/delete) 
 * - "user_id"  	[int]    : populated with the supplied user info. (May be renamed. See bellow.)
 * - "change"   	[string] : depending on setting either : 
 * 							[name (alek) => (Alek), age (28) => (29)] or [name, age]
 * 
 * - "version_id"	[int]	 : cooperates with RevisionBehavior to link the shadow table (thus linking to old data)
 * 
 * Remember that Logable behavior needs to be added after RevisionBehavior. In fact, just put it last to be safe.
 * 
 * 
 * - In AppController (or single controller if only needed once) add these lines to beforeFilter : 
 * 
 *   	if (sizeof($this->uses) && $this->{$this->modelClass}->Behaviors->attached('Logable')) {
 *			$this->{$this->modelClass}->setUserData($this->activeUser);
 *		}
 *
 *   Where "$activeUser" should be an array in the standard format for the User model used :
 * 
 *   $activeUser = array( $UserModel->alias => array( $UserModel->primaryKey => 123, $UserModel->displayField => 'Alexander'));
 *   // any other key is just ignored by this behaviour.
 * 
 * @original-author Alexander Morland (alexander#maritimecolours.no)
 * Greatly refactored and changed by Tim Koschuetzki (tim@debuggable.com)
 * @category Behavior
 * @version 2.1
 * @modified 05.Oct 2009 by Tim Koschuetzki
 */
class LogableBehavior extends ModelBehavior {
	public $user = null;
	public $UserModel = false;
    public $settings = array();
	public $defaults = array(
		'userModel' => 'User',
		'userKey' => 'user_id',
		'change' => 'full',
		'description_ids' => true,
		'skip' => array(),
		'ignore' => array()
	);
/**
 * Cake called intializer
 * Config options are :
 *    userModel 		: 'User'. Class name of the user model you want to use (User by default), if you want to save User in log
 *    userKey   		: 'user_id'. The field for saving the user to (user_id by default).
 * 	  change    		: 'list' > [name, age]. Set to 'full' for [name (alek) => (Alek), age (28) => (29)]
 * 	  description_ids 	: true. Set to false to not include model id and user id in the title field
 *    skip  			: array(). String array of actions to not log
 *
 * @param Object $Model
 * @param array $config
 */
	function setup(&$Model, $config = array()) {
		if (!is_array($config)) {
			$config = array();
		}
		$this->settings[$Model->alias] = array_merge($this->defaults, $config);
		$this->settings[$Model->alias]['ignore'][] = $Model->primaryKey; 

		$this->Log = ClassRegistry::init('Logging.Log');
		$this->UserModel = $this->settings[$Model->alias]['userModel'] != $Model->alias
							? ClassRegistry::init($this->settings[$Model->alias]['userModel'])
							: $Model;
	}
/**
 * Use this to supply a model with the data of the logged in User.
 * Intended to be called in AppController::beforeFilter like this :
 *
 * if ($this->{$this->modelClass}->Behaviors->attached('Logable')) {
 *		$this->{$this->modelClass}->setUserData($activeUser);/
 * }
 *
 * The $userData array is expected to look like the result of a 
 * User::find(array('id'=>123));
 * 
 * @param Object $Model
 * @param array $userData
*/
	function setUserData(&$Model, $userData = null) {
		if ($userData) {
			$this->user = $userData;
		}
	}
/**
 * Used for logging custom actions that arent crud, like login or download.
 *
 * @example $this->Boat->customLog('ship', 66, array('title' => 'Titanic heads out'));
 * @param Object $Model
 * @param string $action name of action that is taking place (dont use the crud ones)
 * @param int $id  id of the logged item (ie model_id in logs table)
 * @param array $values optional other values for your logs table
 */
	function customLog(&$Model, $action, $id, $values = array()) {
		$logData['Log'] = $values;

		if (isset($this->Log->_schema['model_id']) && is_numeric($id)) {
			$logData['Log']['model_id'] = $id;
		}
		$title = null;
		if (isset($values['title'])) {
			$title = $values['title']; 
			unset($logData['Log']['title']);
		}
		$logData['Log']['action'] = $action;
		$this->_saveLog($Model, $logData, $title);
	}
/**
 * undocumented function
 *
 * @param string $Model
 * @return void
 * @access public
 */
	function clearUserData(&$Model) {
		$this->user = null;
	}
/**
 * undocumented function
 *
 * @param string $Model 
 * @param string $userIP 
 * @return void
 * @access public
 */
	function setUserIp(&$Model, $userIP = null) {
		$this->userIP = $userIP;
	}
/**
 * undocumented function
 *
 * @param string $Model 
 * @return void
 * @access public
 */
	function beforeDelete(&$Model) {
		if (!isset($this->settings[$Model->alias]['skip']['delete']) || !$this->settings[$Model->alias]['skip']['delete']) {
			$Model->recursive = -1;
			$Model->read();
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $Model
 * @return void
 * @access public
 */
	function afterDelete(&$Model) {
		$alias = $Model->alias;
		$displayField = $Model->displayField;
		$primaryKey = $Model->primaryKey;
		if (isset($this->settings[$alias]['skip']['delete']) && $this->settings[$alias]['skip']['delete']) {
			return true;
		}
		$logData = array();
		if (isset($this->Log->_schema['description'])) {
			$logData['Log']['description'] = $alias;
			if (isset($Model->data[$alias][$displayField]) && $displayField != $primaryKey) {
				$logData['Log']['description'] .= ' "' . $Model->data[$alias][$displayField] . '"';
			}
			if ($this->settings[$alias]['description_ids']) {
				$logData['Log']['description'] .= ' (' . $Model->id . ') ';
			}
			$logData['Log']['description'] .= __('deleted', true);
		}
		$logData['Log']['action'] = 'delete';
		$this->_saveLog($Model, $logData);
	}
/**
 * undocumented function
 *
 * @param string $Model 
 * @return void
 * @access public
 */
	function beforeSave(&$Model) {
		if (isset($this->Log->_schema['change']) && $Model->id) {
			$this->old = $Model->find('first', array(
				'conditions' => array(
					$Model->primaryKey => $Model->id
				),
				'recursive'=>-1
			));
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $Model 
 * @param string $created 
 * @return void
 * @access public
 */
    function afterSave(&$Model, $created) {
		$alias = $Model->alias;
		$displayField = $Model->displayField;
		$primaryKey = $Model->primaryKey;

		if (isset($this->settings[$alias]['skip']['add']) &&
			$this->settings[$alias]['skip']['add'] && $created) {
			return true;
		}
		if (isset($this->settings[$alias]['skip']['edit']) &&
			$this->settings[$alias]['skip']['edit'] && !$created) {
			return true;
		}
		if (!isset($Model->data[$alias])) {
			return true;
		}

		$keys = array_keys($Model->data[$alias]);
		$diff = array_diff($keys, $this->settings[$alias]['ignore']);
		if (count($diff) == 0 && empty($Model->logableAction)) {
			return false;
		}

		$id = $Model->id;
		$logData = array();
		if (isset($this->Log->_schema['model_id'])) {
			$logData['Log']['model_id'] = $id;
		}

		if (isset($this->Log->_schema['description'])) {
			$logData['Log']['description'] = $alias . ' ';
			if (isset($Model->data[$alias][$displayField]) && $displayField != $Model->primaryKey) {
				$logData['Log']['description'] .= '"' . $Model->data[$alias][$displayField] . '" ';
			}

			if ($this->settings[$alias]['description_ids']) {
				$logData['Log']['description'] .= '(' . $id . ') ';
			}

			if ($created) {
				$logData['Log']['description'] .= __('added', true);
			} else {
				$logData['Log']['description'] .= __('updated', true);
			}
		}

		if (isset($this->Log->_schema['action'])) {
			if ($created) {
				$logData['Log']['action'] = 'add';
			} else { 
				$logData['Log']['action'] = 'edit';
			}
		}

		if (isset($this->Log->_schema['change'])) {
			$logData['Log']['change'] = '';
			$dbFields = array_keys($Model->_schema);
			$changedFields = array();

			foreach ($Model->data[$alias] as $key => $value) {
				$old = '';
				if (isset($Model->data[$alias][$Model->primaryKey]) &&
					!empty($this->old) &&
					isset($this->old[$alias][$key])) {
					$old = $this->old[$alias][$key];
				}

				if ($key != 'modified' && !in_array($key, $this->settings[$alias]['ignore']) &&
					$value != $old && in_array($key, $dbFields)) {
					if ($this->settings[$alias]['change'] == 'full') {
						$changedFields[] = $key . ' (' . $old . ') => (' . $value . ')';
					} else {
						$changedFields[] = $key;
					}
				}
			}
			$changes = count($changedFields);

			if ($changedFields == 0) {
				return true;
			} 
			$logData['Log']['change'] = implode(', ', $changedFields);
			$logData['Log']['changes'] = $changes;
		}

		$this->_saveLog($Model, $logData);
	}
/**
 * Does the actual saving of the Log model. Also adds the special field if possible.
 * 
 * If model field in table, add the Model->alias
 * If action field is NOT in table, remove it from dataset
 * If the userKey field in table, add it to dataset
 * If userData is supplied to model, add it to the title 
 *
 * @param Object $Model
 * @param array $logData
 */
	function _saveLog(&$Model, $logData, $title = null) {
		if (empty($logData)) {
			return false;
		}
		$alias = $Model->alias;
		$displayField = $Model->displayField;
		$primaryKey = $Model->primaryKey;

		$userAlias = $this->UserModel->alias;
		$userPrimaryKey = $this->UserModel->primaryKey;

		if ($title !== null) {
			$logData['Log']['title'] = $title;
		} elseif ($displayField == $primaryKey) {
			$logData['Log']['title'] = $alias . ' (' . $Model->id . ')';
		} elseif (isset($Model->data[$alias][$displayField])) {
			$logData['Log']['title'] = $Model->data[$alias][$displayField];
		} else {
			$Model->recursive = -1;
			$Model->read(array($displayField));
			$logData['Log']['title'] = $Model->data[$alias][$displayField];
		}

		if (isset($this->Log->_schema['model'])) {
			$logData['Log']['model'] = $alias;
		}

		if (isset($this->Log->_schema['model_id']) && !isset($logData['Log']['model_id'])) {
			if ($Model->id) {
				$logData['Log']['model_id'] = $Model->id;
			} elseif ($Model->insertId) {
				$logData['Log']['model_id'] = $Model->insertId;
			}
		}

		if (!isset($this->Log->_schema[ 'action' ])) {
			unset($logData['Log']['action']);
		} elseif (isset($Model->logableAction) && !empty($Model->logableAction)) {
			$logData['Log']['action'] = implode(',', $Model->logableAction); // . ' ' . $logData['Log']['action'];
			unset($Model->logableAction);
		}

		if (isset($this->Log->_schema['version_id']) && isset($Model->version_id)) {
			$logData['Log']['version_id'] = $Model->version_id;
			unset($Model->version_id);
		}

		if (isset($this->Log->_schema['ip']) && $this->userIP) {
			$logData['Log']['ip'] = $this->userIP;
		}

		if (isset($this->Log->_schema[$this->settings[$alias]['userKey']]) && $this->user) {
			$logData['Log'][$this->settings[$alias]['userKey']] = $this->user[$userAlias][$userPrimaryKey];
		}

		if (isset($this->Log->_schema['description'])) {
			if ($this->user && $this->UserModel) {
				$logData['Log']['description'] .= ' by ' . $this->settings[$alias]['userModel'] . ' "' .
					$this->user[$this->UserModel->alias][$this->UserModel->displayField] . '"';
				if ($this->settings[$alias]['description_ids']) {
					$logData['Log']['description'] .= ' (' . $this->user[$userAlias][$userPrimaryKey] . ')';
				}
			} else { 
				// UserModel is active, but the data hasnt been set. Assume system action.
				$logData['Log']['description'] .= ' by System';
			}
			$logData['Log']['description'] .= '.';
		}
		$this->Log->create($logData);
		$this->Log->save();
	}
}
?>