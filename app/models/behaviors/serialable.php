<?php 
/**
 * Serialable Behavior Behavior class file.
 *
 * @filesource
 * @author Tim Koschuetzki
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 */
/**
 * Model behavior to support an uuid-independent unique id (serial) for a model object
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class SerialableBehavior extends ModelBehavior {
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
 * @param object $Model Model using the behaviour
 * @param array $settings Settings to override for model.
 * @access public
 */
	function setup(&$Model, $settings = array()) {
		$defaults = array(
			'field' => 'serial',
			'length' => 5,
			'model' => 'User'
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
			$this->serial($Model, $Model->id, true);
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
	function serial($Model, $id, $forceCreate = false) {
		$field = $this->__settings[$Model->alias]['field'];
		$length = $this->__settings[$Model->alias]['length'];
		App::import('Core', 'Security');
		if (!$forceCreate) {
			$key = $Model->lookup(compact('id'), $field, false);
			if (!empty($key)) {
				return $key;
			}
		}

		do {
			$key = Security::generateAuthKey();
			$key = substr($key, 0, $length);
		} while (!$Model->isUnique(array($field => $key)));

		$Model->set(array('id' => $id, $field => $key));
		$Model->save();
		return $key;
	}
}
?>