<?php
class Favorite extends FavoritesAppModel{
	var $belongsTo = array('User');
/**
 * undocumented function
 *
 * @param string $model 
 * @return void
 * @access public
 */
	function doForModel($model) {
		$favConfig = Configure::read('Favorites');
		return in_array($model, array_keys($favConfig['models']));
	}
/**
 * undocumented function
 *
 * @param string $userId 
 * @return void
 * @access public
 */
	function load($userId) {
		$favorites = $this->find('all', array(
			'conditions' => array('user_id' => $userId),
			'contain' => false,
			'fields' => array('foreign_id')
		));

		$favorites = Set::extract('/Favorite/foreign_id', $favorites);
		$Session = Common::getComponent('Session');
		$Session->write('favorites', $favorites);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function isFavorited($id) {
		$Session = Common::getComponent('Session');
		return in_array($id, $Session->read('favorites'));
	}
}