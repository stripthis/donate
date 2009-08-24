<?php
class Comment extends CommentsAppModel {
	var $belongsTo = array('User');
/**
 * undocumented function
 *
 * @param string $comment 
 * @return void
 * @access public
 */
	static function isOwn($comment) {
		$isAuthor = $isOwned = AppModel::isOwn($comment, 'Comment');
		if (!$isAuthor) {
			$isOwned = false;
			$models = $this->belongsTo;
			foreach ($models as $model => $data) {
				$row = $this->{$model}->find('first', array(
					'conditions' => array($model . '.id' => $comment['Comment']['foreign_id']),
					'contain' => false
				));

				if (!empty($row) && AppModel::isOwn($row, $model)) {
					$isOwned = true;
					break;
				}
			}
			Assert::true($isOwned, '403');
		}
		return $isOwned;
	}
}
?>