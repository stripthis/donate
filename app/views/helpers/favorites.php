<?php
/**
 * Favorites Helper
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Greenpeace International
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php  
 */
class FavoritesHelper extends Apphelper {
	var $helpers = array('Html');
	var $config; 
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeRender() {
		$this->config = Configure::read('Favorites');
		$this->config['icons'] = array(
			'fav' => '/img/icons/S/rate.png',
			'unfav' => '/img/icons/S/unrate.png'
		);
	}
/**
 * 
 * @param $model
 * @param $uuid
 * @return string link
 */	
	function link($model, $uuid) {
		$isFavorited = ClassRegistry::init('Favorite')->isFavorited($uuid);
		if (!$isFavorited) {
			$img = $this->Html->image(
				$this->config['icons']['unfav'], 
				array('alt'=>__(ucfirst($this->config['verb']), true))
			);
			return $this->Html->link($img, array(
				'controller' => 'favorites', 'action' => 'add', $uuid, $model
				), array('class' => 'star', 'escape'=>false
			));
		} else {
			$img = $this->Html->image(
				$this->config['icons']['fav'], 
				array('alt'=>__(ucfirst($this->config['verb']), true))
			);
			return $this->Html->link($img, array(
				'controller' => 'favorites', 'action' => 'delete', $uuid, $model
				), array('class' => 'star', 'escape'=>false
			));
		}
	}
/**
 * 
 * @param $model
 * @return string link
 */
	function favall($model=null){
		return $this->Html->image('icons/S/rate.png');
	}
}
?>