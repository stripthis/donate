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
}