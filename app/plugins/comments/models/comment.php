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
		$isAuthor = $comment['Comment']['user_id'] == User::get('id');
		$isOwned = false;
		if (!$isAuthor) {
			$models = $this->belongsTo;
			foreach ($models as $model => $data) {
				$row = $this->{$model}->find('first', array(
					'conditions' => array($model . '.id' => $comment['Comment']['foreign_id'])
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