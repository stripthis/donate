<?php 
/**
 * SavedBy Behavior class file.
 *
 * @filesource
 * @author Tim Koschuetzki
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 */
/**
 * Model behavior to support created by and modified by user fields
 *
 * @package app
 * @subpackage app.models.behaviors
 */
class SavedByBehavior extends ModelBehavior {
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
			'createdField' => 'created_by',
			'modifiedField' => 'modified_by',
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
 * Run before a model is saved, used to disable beforeFind() override.
 *
 * @param object $Model Model about to be saved.
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 */
	function beforeSave(&$Model, $options = array()) {
		if (class_exists('ShellDispatcher') || defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			return true;
		}
		if (!$Model->id) {
			$createdField = $this->__settings[$Model->alias]['createdField'];
			if ($createdField) {
				$Model->data[$Model->alias][$createdField] = User::get('id');
			}
		}
		$modifiedField = $this->__settings[$Model->alias]['modifiedField'];
		if ($modifiedField) {
			$Model->data[$Model->alias][$modifiedField] = User::get('id');
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFind(&$Model, $query = array()) {
		$createdField = $this->__settings[$Model->alias]['createdField'];
		$modifiedField = $this->__settings[$Model->alias]['modifiedField'];
		$model = $this->__settings[$Model->alias]['model'];

		if ($createdField) {
			$Model->bindModel(array('belongsTo' => array(
				'CreatedBy' => array(
					'className' => $model,
					'foreignKey' => $createdField
				),
			)));
		}

		if ($createdField) {
			$Model->bindModel(array('belongsTo' => array(
				'ModifiedBy' => array(
					'className' => $model,
					'foreignKey' => $modifiedField
				),
			)));
		}
	}
}
?>