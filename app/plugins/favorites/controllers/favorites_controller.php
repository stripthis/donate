<?php
class FavoritesController extends FavoritesAppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->models = array_keys(Configure::read('Favorites.models'));
		foreach ($this->models as $model) {
			$this->$model = ClassRegistry::init($model);
			$this->Favorite->bindModel(
				array('belongsTo' => array(
					$model => array('foreignKey' => 'foreign_id')
				))
			);
		}
	}
/**
 * undocumented function
 *
 * @return void
 */
	function admin_index($model = 'all') {
		if ($model == 'all') {
			$model = $this->models;
		} else {
			if (!in_array($model, $this->models)) {
				$model = $this->models;
			} else {
				$model = array($model);
			}
		}

		$favorites = $this->Favorite->find('all', array(
			'contain' => $model,
			'order' => array('Favorite.created' => 'desc')
		));
		$this->set(compact('favorites', 'model'));
	}
/**
 * undocumented function
 *
 * @return void
 */
	function admin_add($id = null, $model = false) {
		$userId = User::get('id');
		$favorite = $this->Favorite->find('first', array(
			'conditions' => array('user_id' => $userId, 'foreign_id' => $id)
		));

		$adj = Configure::read('Favorites.adjective');
		$model = empty($model) ? 'object' : low($model);
		if (empty($favorite)) {
			$this->Favorite->create(array(
				'user_id' => $userId,
				'foreign_id' => $id
			));
			$this->Favorite->save();
			$this->Favorite->load(User::get('id'));

			$msg = __('This ' . $model . ' was successfully ' . $adj . '!', true);
			return $this->Message->add($msg, 'ok', true, $this->referer());
		}

		$msg = __('This ' . $model . ' is already ' . $adj . '!', true);
		$this->Message->add($msg, 'error', true, $this->referer());
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id = null, $model = false) {
		$userId = User::get('id');
		$favorite = $this->Favorite->find('first', array(
			'conditions' => array('user_id' => $userId, 'foreign_id' => $id)
		));

		$adj = Configure::read('Favorites.adjective');
		$model = empty($model) ? 'object' : low($model);
		if (empty($favorite)) {
			$msg = __('This ' . $model . ' was not ' . $adj . ' in the first place.', true);
			return $this->Message->add($msg, 'error', true, $this->referer());
		}

		$this->Favorite->del($favorite['Favorite']['id']);
		$this->Favorite->load(User::get('id'));

		$subject = Configure::read('Favorites.subject');
		$msg = __('This ' . $model . ' was successfully removed from your ' . Inflector::pluralize($subject) . '.', true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
}
?>