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
		$conditions = array('Favorite.user_id' => $userId);
		$favConfig = Configure::read('Favorites');
		if (isset($favConfig['loadConditions'])) {
			$conditions = am($conditions, $favConfig['loadConditions']);
		}

		$models = array_keys($favConfig['models']);
		$options = array();
		foreach ($models as $model) {
			$options[$model] = array('foreignKey' => 'foreign_id');
		}
		$this->bindModel(array('belongsTo' => $options), false);

		$favorites = $this->find('all', array(
			'conditions' => $conditions,
			'contain' => $models,
			'fields' => array('Favorite.foreign_id', 'Favorite.model')
		));

		$Session = Common::getComponent('Session');

		$simple = Set::extract('/Favorite/foreign_id', $favorites);
		$Session->write('favorites', $simple);

		$verbose = array();
		foreach ($models as $model) {
			$verbose[$model] = 0;
			foreach ($favorites as $fav) {
				if (!empty($fav[$model]['id'])) {
					$verbose[$model]++;
				}
			}
		}
		$Session->write('verbose_favorites', $verbose);
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