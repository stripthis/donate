<?php 
class HabtmCounterCachableBehavior extends ModelBehavior {
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave(&$model, $created) {
		$this->updateHABTMcounters($model);
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @return void
 * @access public
 */
	private function updateHABTMcounters(&$model) {
		if (!isset($model->hasAndBelongsToMany)) {
			return false;
		}

		foreach ($model->hasAndBelongsToMany as $associatedModel => $params) {
			$field = Inflector::underscore($associatedModel).'_count';                
			if (!isset($params['counterCache']) || !$params['counterCache'] || !$model->hasField($field)) {
				continue;
			}

			$this->bindByInnerJoin($model, $associatedModel);            
			$conditions = array(Inflector::camelize($model->name) . '.id' => $model->id);
			if (isset($params['counterScope'])) {
				$conditions = am($conditions, (array)$params['counterScope']);
			}
			$count=$model->find('count', compact('conditions'));
			$model->saveField($field, $count, array('callbacks' => false));
		}
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $associatedModel 
 * @return void
 * @access public
 */
	private function bindByInnerJoin(&$model, $associatedModel) {
		if (!isset($model->hasAndBelongsToMany[$associatedModel])) {
			return false;
		}

		$params = $model->hasAndBelongsToMany[$associatedModel];
		$model->unbindModel(array('hasAndBelongsToMany' => array_keys($model->hasAndBelongsToMany)));

		$conditions = $params['with'] . '.' . $params['foreignKey'] . '=' . Inflector::camelize($model->name) . '.id';
		$model->bindModel(array('belongsTo' => array(
			$params['with'] => array(
				'className' => $params['with'],
				'type' => 'INNER',
				'foreignKey' => false,
				'conditions' => $conditions
			)
		)));
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @return void
 * @access public
 */
	function afterDelete(&$model) {
		if (!isset($model->hasAndBelongsToMany)) {
			return true;
		}

		foreach($model->hasAndBelongsToMany as $associatedModel => $params) {
			if (!isset($model->store[$associatedModel])) {
				continue;
			}
			foreach ($model->store[$associatedModel] as $associated) {
				$model->associateModel->id = $associated[$associatedModel]['id'];
				$data = array('id' => $associated[$associatedModel]['id']);
				$model->$associatedModel->save($data, false);
			}
		}
		unset($model->store[$associatedModel]);
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @return void
 * @access public
 */
	function beforeDelete(&$model) {
		if (!isset($model->hasAndBelongsToMany)) {
			return true;
		}

		$model->store = array();
		$field = Inflector::underscore($model->name).'_count';
		foreach ($model->hasAndBelongsToMany as $associatedModel=>$params) {
			$params_associated = $model->$associatedModel->hasAndBelongsToMany[$model->name];
			if (!isset($params_associated['counterCache']) || !$params_associated['counterCache'] ||  !$model->$associatedModel->hasField($field)) {
				continue;
			}

			$this->bindByInnerJoin($model->$associatedModel, $model->name);
			$results = $model->$associatedModel->find('all', array(
				'fields' => array(Inflector::underscore($associatedModel).' . id'),
				'conditions' => array($params['foreignKey'] => $model->id)
			));
			if (count($results)) {
				$model->store[$associatedModel] = $results;
			}
		}
		return true;
	}

}
?>