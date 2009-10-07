<?php
class CommentsAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		$config = Configure::read('Comments');

		$this->Comment = ClassRegistry::init('Comments.Comment');
		foreach ($config['models'] as $model => $threaded) {
			$Model = ClassRegistry::init($model);
			$Model->bindModel(array('hasMany' => array(
				'Comment' => array(
					'className' => 'Comments.Comment',
					'dependent' => true,
					'foreignKey' => 'foreign_id',
					'threaded' => $threaded
				)
			)), false);
			
			$this->Comment->bindModel(array('belongsTo' => array(
				$model => array('foreignKey' => 'foreign_id')
			)), false);
		}
	}
}
?>