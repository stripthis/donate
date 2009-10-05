<?php
class Log extends LoggingAppModel {
	var $belongsTo = array('User');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFind() {
		$config = Configure::read('Logging');
		foreach ($config['models'] as $model) {
			$this->bindModel(array('belongsTo' => array(
				$model => array('foreignKey' => 'model_id')
			)));
		}
	}
}
?>