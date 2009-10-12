<?php 
/**
 * ContinuousId Behavior Behavior class file.
 *
 * @filesource
 * @author Tim Koschuetzki
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 */
/**
 * Model behavior to support an uuid-independent continous id for a model object
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class ContinuousIdBehavior extends ModelBehavior {
/**
 * Contain settings indexed by model name.
 *
 * @var array
 * @access private
 */
	var $__settings = array();
/**
 * Initiate behavior for the model using settings.
 *
 * @param object $Model Model using the behavior
 * @param array $settings Settings to override for model.
 * @access public
 */
	function setup(&$Model, $settings = array()) {
		$defaults = array(
			'field' => 'continuous_id',
			'offset' => '1'
		);

		if (!isset($this->__settings[$Model->alias])) {
			$this->__settings[$Model->alias] = $defaults;
		}
		$this->__settings[$Model->alias] = am(
			$this->__settings[$Model->alias],
			ife(is_array($settings), $settings, array())
		);
	}
/**
 * undocumented function
 *
 * @param string $Model 
 * @param string $created 
 * @return void
 * @access public
 */
	function afterSave($Model, $created) {
		if ($created) {
			$this->id($Model, $Model->id, true);
		}
		return true;
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @param string $forceCreate
 * @return void
 * @access public
 */
	function id($Model, $id, $forceCreate = false) {
		$field = $this->__settings[$Model->alias]['field'];
		$offset = $this->__settings[$Model->alias]['offset'];
		App::import('Core', 'Security');

		$key = $Model->lookup(compact('id'), $field, false);
		if (!empty($key)) {
			return $key;
		}

		$last = $Model->find('all', array(
			'order' => array($Model->alias . '.created' => 'desc'),
			'limit' => 2
		));

		// take the last but one if possible, cause the last will be the just saved one (with id = $id)
		if (isset($last[1])) {
			$last = $last[1];
		} else {
			$last = false;
		}

		$key = $offset;
		if (!empty($last) && $last[$Model->alias][$field] >= $offset) {
			$key = $last[$Model->alias][$field] + 1;
		}
		$Model->set(array('id' => $id, $field => $key));
		$Model->save(null, false);
		return $key;
	}
}
?>